<?php

namespace app\controllers;
use Yii;
use app\models\brp\Tblrscobrp;
use kartik\mpdf\Pdf;
use app\models\hronline\Tblprcobiodata;
use yii\data\Pagination;
use app\models\hronline\Updatestatus;
use yii\data\ActiveDataProvider;
use app\models\brp\StafAkses;
use yii\helpers\ArrayHelper;
use app\models\vhrms\ViewPayroll;
use app\models\hronline\Tblkeluarga;
use app\models\hronline\Tblpengalamankerja;
use app\models\hronline\Tblpendidikan;
use app\models\hronline\Tblrscopsnstatus;
use app\models\hronline\Tblretireage;
use app\models\gaji\TblStaffRocBatch;
use app\models\gaji\TblStaffRoc;
use app\models\hronline\TblprcobiodataSearch;
use yii\helpers\Html;
use app\models\brp\Brp;
use app\models\gaji\TblStaffRocBatchSmbu;
use yii\filters\AccessControl;
use app\models\hronline\Umsper;
use yii\filters\VerbFilter;

error_reporting(0);

class BrpController extends \yii\web\Controller{
    
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
                ],
            ],
        ];
    }
    
    
    public function actionIndex() {        
        $carian = new TblprcobiodataSearch();
        $dataProvider = $carian->carian(Yii::$app->request->queryParams);  

        return $this->render('index', [
                    'carian' => $carian,
                    'model' => $dataProvider,
        ]);
   
    }
    
    
        public function actionCarianBsm() {
        $permohonan = $this->SenaraiRekodBrp();
        $search = new Tblprcobiodata();

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['carian-rekod-brp', 'ICNO' => $search->ICNO]);  
        }

        return $this->render('carian-bsm', [
                     'permohonan' => $permohonan,
                    'search' => $search,
        ]);
    }
    
        public function SenaraiRekodBrp() {
        $data = new ActiveDataProvider([
            'query' => Tblprcobiodata::find()->where(['Status' => 1]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        
        return $data;
    }
    
 
        public function actionCarianRekodBrp($ICNO) {
         $permohonan = $this->GridCarianRekodBrp($ICNO);
         $search = new Tblprcobiodata();

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['carian-rekod-brp', 'ICNO' => $search->ICNO]);
            
        }

        return $this->render('carian-bsm', [
                    'permohonan' => $permohonan,
                    'search' => $search,
                    'ICNO' => $ICNO,
        ]);
    }
    
      public function GridCarianRekodBrp($ICNO) {
        $data = new ActiveDataProvider([
            'query' => Tblprcobiodata::find()->where(['ICNO' => $ICNO]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

     public function actionView($ICNO) {
   //    $model = $this->findModel($ICNO);
       $model = \app\models\hronline\Umsper::find()->where(['ICNO' => $ICNO])->one();
       $model2 = \app\models\hronline\Umsper::find()->where(['ICNO' => $ICNO])->asArray()->all();
       $icno = Yii::$app->user->getId();
       
       $sah = Tblrscobrp::find()->where(['icno' => $model->ICNO])->orderBy(['tarikh_mulai' => SORT_DESC])->all();

         if ($pilih = Yii::$app->request->post()) {

            foreach ($pilih['Tblrscobrp']['brp_id'] as $k => $v) {
                if ($v != 0) {
                    $models = Tblrscobrp::findOne($v);
                    $models->sah = '1';
                    $models->sah_by = $icno;
                    $models->sah_date = date('Y-m-d H:i:s');
                   ($models->save(false)); 
                }
            }
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod Telah Disahkan!']);
             return $this->redirect(['brp/view', 'ICNO' => $model->ICNO]);
        }

        return $this->render('view', ['model' => $model, 'sah' => $sah, 'bil' => 1, 'model2' => $model2]);
    }
    
       public function actionChecklistBrp($ICNO) {
       $model = $this->findModel($ICNO);
       $query= Tblrscobrp::find()->where(['icno' => $ICNO]);
           $provider = new ActiveDataProvider([
           'query' => $query,
           'pagination' => [
           'pageSize' =>  10
           ],
            
       ]);
        return $this->render('checklist-brp', ['model' => $model,  'provider' => $provider, 'bil' => 1]);
    }
    
     
    
       public function actionPengesahan($brp_id) {
          $icno = Yii::$app->user->getId();
          $model = Tblrscobrp::findOne(['brp_id' => $brp_id]);
            if ($model->load(Yii::$app->request->post())) {
                $model->sah_date = date('Y-m-d H:i:s');
                $model->sah_by = $icno;
                $model->save();
            } 
             return $this->renderAjax('pengesahan', ['model' => $model]);
    }
    
      public function actionPadamPengesahan($brp_id) {
        $model = Tblrscobrp::findOne(['brp_id' => $brp_id]);
        $model->delete();
        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Rekod Berjaya Dipadam']);

        return $this->redirect(['view', 'ICNO' => $model->icno]);
    }
    
    
     public function actionKemaskiniPengesahan($brp_id){         
        $update = Tblrscobrp::find()->where(['brp_id' => $brp_id])->one();
        $listdata = ArrayHelper::map(Brp::find()->all(), 'brpCd', 'brpTitle');

        if ($update->load(Yii::$app->request->post()) && $update->save(false)) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dikemaskini']); 
            return $this->redirect(['view', 'ICNO' => $update->kakitangan->ICNO]);
        } 
        return $this->render('kemaskini-pengesahan', ['update' => $update, 'listdata' => $listdata]); 
      }
      
      public function actionTambahRekod($ICNO){   
             $model = \app\models\hronline\Umsper::find()->where(['ICNO' => $ICNO])->one();
        $icno = Yii::$app->user->getId();
        $tambah = new Tblrscobrp();
        $listdata = ArrayHelper::map(Brp::find()->all(), 'brpCd', 'brpTitle');
            if ($tambah->load(Yii::$app->request->post())) {
            $tambah->icno = $ICNO;
            $tambah->status = 1;
            $tambah->status_update_by = $icno;
            $tambah->status_date = date('Y-m-d H:i:s');
            $tambah->save();
  
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya disimpan']); 
            return $this->redirect(['view', 'ICNO' => $ICNO]);
        } 
        return $this->render('tambah-rekod', ['tambah' => $tambah, 'listdata' => $listdata, 'model' => $model]); 
      } 
      
//       public function actionTambahRekod($ICNO, $titlebrp=NULL){   
//        $icno = Yii::$app->user->getId();
//        $tambah = new Tblrscobrp();
//        $listdata = ArrayHelper::map(Brp::find()->all(), 'brpCd', 'brpTitle');
//            if ($tambah->load(Yii::$app->request->post())) {
//                $brp =Brp::find()->where(['brpCd' =>$titlebrp])->one();
//                    $array = explode('_', $brp->brpBottomDesc);
//                    $formy = explode(',', $brp->brpForm);
//                    $f=0;
//                    for ($i=0;$i<=count($array);$i++){
//                        if($array[$i] !=''){
//                            if($formy[$f]==''){
//                            $remark = $remark.' '.$array[$i]; 
//                            }
//                            else {
//                                if (Yii::$app->request->post($formy[$f])) {
//                                  
//                                        $remark = $remark.' '.$array[$i].Yii::$app->request->post($formy[$f]);
//                                }          
//                                else
//                                {
//                                        $remark = $remark.' '.$array[$i].Brp::Brp($formy[$f], $ICNO); 
//                                }
//                            }
//                            $f++;
//                        }
//                    }
//                    
//            $tambah->icno = $ICNO;
//            $tambah->status = 1;
//            $tambah->status_update_by = $icno;
//            $tambah->status_date = date('Y-m-d H:i:s');
//            $tambah->save(false);
//  
//            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya disimpan']); 
//            return $this->redirect(['view', 'ICNO' => $ICNO]);
//        } 
//        return $this->render('tambah-rekod', ['tambah' => $tambah, 'listdata' => $listdata, 'titlebrp' => $titlebrp, 'ICNO' => $ICNO]); 
//      } 
      
        public function actionTambahRekodLpg($ICNO){   
              $model = \app\models\hronline\Umsper::find()->where(['ICNO' => $ICNO])->one();
        $icno = Yii::$app->user->getId();
        $tambah = new Tblrscobrp();
        $listdata = ArrayHelper::map(Brp::find()->all(), 'brpCd', 'brpTitle');
            if ($tambah->load(Yii::$app->request->post())) {
            $tambah->icno = $ICNO;
            $tambah->status = 1;
            $tambah->status_update_by = $icno;
            $tambah->status_date = date('Y-m-d H:i:s');
            $tambah->save();
  
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya disimpan']); 
            return $this->redirect(['view', 'ICNO' => $ICNO]);
        } 
        return $this->render('tambah-rekod-lpg', ['tambah' => $tambah, 'listdata' => $listdata, 'model' => $model]); 
      } 
      
//          public function actionViewRekodLpg($COOldID){   
//        $icno = Yii::$app->user->getId();
//        $model = TblStaffRocBatchSmbu::find()->where(['srb_staff_id' => $COOldID])->one();    
//        $view =   TblStaffRocBatchSmbu::find()->where(['srb_staff_id' => $COOldID])->orderBy(['srb_effective_date' => SORT_DESC])->all();
//
//         if ($pilih = Yii::$app->request->post()) {
//             
//               foreach ($pilih['dbo.staff_roc_batch']['srb_batch_code'] as $k => $v) {
//                if ($v != 0) {
//                    
//                    $modelss = TblStaffRocBatchSmbu::findOne($v);
//                    $models = new Tblrscobrp(); 
//                    $models->sah = '1';
//                    $models->sah_by = $icno;
//                    $models->sah_date = date('Y-m-d H:i:s');
//                    $models->icno =  $modelss->biodataSendiri->ICNO;
//                    $models->status = 1;
//                    $models->status_update_by = $icno;
//                    $models->status_date = date('Y-m-d H:i:s');
//                    $models->brpCd = "LPG".($modelss->srb_change_reason);
//                    $models->data_source = "LPG";
//                    $models->remark = $modelss->srb_remarks;
//                    $models->t_lpg_id = $modelss->srb_batch_code;
//                   ($models->save(false)); 
//                }
//            }
//            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod Telah Disahkan!']);
//             return $this->redirect(['brp/view-rekod-lpg', 'COOldID' => $model->srb_staff_id]);
//        }
//       
//        return $this->render('view-rekod-lpg', ['model' => $model, 'view' => $view, 'models' => $models, 'modelss' => $modelss]); 
//      } 
      
        public function actionViewRekodLpg($COOldID){
    
        $model = TblStaffRocBatchSmbu::find()->where(['srb_staff_id' => explode(",",$COOldID)])->one(); 
        $brp = Tblrscobrp::find()->where(['icno' => $model->biodataTerbaru->ICNO])->one();
        $icno = Yii::$app->user->getId();
        $searchModel = new \app\models\gaji\TblStaffRocBatchSmbuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where(['srb_staff_id' => explode(",",$COOldID)])->orderBy(['srb_verify_date' => SORT_DESC]);
        
          $model2 = \app\models\hronline\Umsper::find()->where(['ICNO' => $model->biodataTerbaru->ICNO])->one();
          
          
        $searchModel2 = new \app\models\brp\tblrscobrpSearch();
        $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams);
        $dataProvider2->query->where(['icno' => $model->biodataTerbaru->ICNO])->orderBy(['tarikh_mulai' => SORT_DESC]);
        
        $pencen = Tblrscopsnstatus::find()->where(['ICNO' => $model->biodataTerbaru->ICNO])->andWhere(['PsnStatusCd' => 1])->orderBy(['PsnStatusStDt' => SORT_ASC])->one();
        
          
        if (Yii::$app->request->post('simpan')) {
        $arrayId = Yii::$app->request->post('selection');
        
            foreach($arrayId as $k => $v) {
                    $modelss = TblStaffRocBatchSmbu::findOne($v);
                  //  $modelz = TblStaffRoc::findOne($v);
                    
                    $models = new Tblrscobrp(); 
                    $models->sah = '1';
                    $models->sah_by = $icno;
                    $models->sah_date =  $modelss->staffRoc3->SR_APPROVE_DATE;
                    $models->icno =  $modelss->biodataTerbaru->ICNO;
                    $models->status = 1;
                    $models->status_update_by = $icno;
                    $models->status_date = date('Y-m-d H:i:s');
                    $models->brpCd = "LPG".($modelss->srb_change_reason);
                    $models->data_source = "LPG";
                    $models->remark = $modelss->srb_remarks;
                    $models->t_lpg_id = $modelss->srb_batch_code;
                    $models->jawatan_id = $brp->kakitangan->gredJawatan;
                    if($modelss->srb_enter_date != null){
                    $models->tarikh_mulai = \Yii::$app->formatter->asDate($modelss->srb_enter_date, 'yyyy-MM-dd');
                    $models->insert_date = $modelss->srb_enter_date;
                    $models->tarikh_surat = \Yii::$app->formatter->asDate($modelss->srb_enter_date, 'yyyy-MM-dd'); 
                    }  
                    else if($modelss->srb_approve_date != null){
                         $models->tarikh_lulus = \Yii::$app->formatter->asDate($modelss->srb_approve_date, 'yyyy-MM-dd'); 
                    }
                    else{
                    $models->tarikh_mulai = null;
                    $models->tarikh_lulus = null;
                    $models->insert_date = null;
                    $models->tarikh_surat = null;
                    }
                    if($pencen->PsnStatusCd == 1){
                    $models->isPencen = 1;
                    } else{
                    $models->isPencen = 0; 
                    }
                
                    ($models->save(false)); 
                    
                } 
                
            
             Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod Telah Disahkan!']);
             return $this->redirect(['brp/view-rekod-lpg', 'COOldID' => $model->srb_staff_id]);
                 
                
       }

      
        return $this->render('view-rekod-lpg', [
            'searchModel' => $searchModel, 'brp' => $brp,'model2' => $model2,
            'dataProvider' => $dataProvider, 'models' => $models, 'model' => $model, 'modelss'=>$modelss, 'dataProvider2'=> $dataProvider2 , 'pencen'=> $pencen 
        ]);
    }
    
//    public function actionViewRekodAnugerah($ICNO){
//        
//        $model = \app\models\hronline\Tblanugerah::find()->where(['ICNO' => $ICNO])->one();    
//        $icno = Yii::$app->user->getId();
//        $searchModel = new \app\models\hronline\TblanugerahSearch;
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $dataProvider->query->where(['ICNO' => $ICNO])->orderBy(['AwdCfdDt' => SORT_DESC]);
//             
//        $searchModel2 = new \app\models\brp\tblrscobrpSearch();
//        $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams);
//        $dataProvider2->query->where(['icno' => $model->ICNO])->orderBy(['status_date' => SORT_DESC]);
//        
//        $tambah = new Tblrscobrp();
//        
//        if ($tambah->load(Yii::$app->request->post())) {
//        $arrayId = Yii::$app->request->post('selection');
//            foreach($arrayId as $k => $v) {
//                    $modelss = \app\models\hronline\Tblanugerah::findOne($v);
//                    $models = new Tblrscobrp(); 
//                    $models->sah = '1';
//                    $models->sah_by = $icno;
//                    $models->icno =  $modelss->ICNO;
//                    $models->brpCd = 20;
//                    $models->status = 1;
//                    $models->status_update_by = $icno;
//                    $models->status_date = date('Y-m-d H:i:s');
//                    $models->sah_date = date('Y-m-d H:i:s');
//                    $models->data_source = "tblprawd";
//                    $models->remark = $modelss->AwdReason;
////                    $models->t_lpg_id = $modelss->AwdCd;
//                    $models->jawatan_id = $tambah->jawatan_id;
//                    $models->tarikh_mulai = $tambah->tarikh_mulai;
//                    $models->tarikh_hingga = $tambah->tarikh_hingga;
//                    $models->tarikh_lulus = $tambah->tarikh_lulus;
//                    $models->rujukan_surat = $tambah->rujukan_surat;
//                    $models->tarikh_surat = $tambah->tarikh_surat;
//                    $models->isPencen = $tambah->isPencen;
//                    $models->gaji_sebulan = $tambah->gaji_sebulan;
//                    ($models->save(false)); 
//                    
//                }
//                
//             Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod Telah Disahkan!']);
//             return $this->redirect(['brp/view-rekod-anugerah', 'ICNO' => $model->ICNO]);
//      
//       }
//      
//        return $this->render('view-rekod-anugerah', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider, 
//            'model' => $model, 
//            'tambah' => $tambah,
//            'dataProvider2'=> $dataProvider2      
//        ]);
//    }
//    
//    public function actionViewRekodBersara($ICNO){
//        
//        $model = \app\models\hronline\Tblrscoretireage::find()->where(['ICNO' => $ICNO])->one();    
//        $icno = Yii::$app->user->getId();
//        $searchModel = new \app\models\hronline\tblrscoretireageSearch;
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $dataProvider->query->where(['ICNO' => $ICNO])->orderBy(['CORetireAgeEftvDt' => SORT_DESC]);
//             
//        $searchModel2 = new \app\models\brp\tblrscobrpSearch();
//        $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams);
//        $dataProvider2->query->where(['icno' => $model->ICNO])->orderBy(['status_date' => SORT_DESC]);
//        
//        $tambah = new Tblrscobrp();
//        
//        if ($tambah->load(Yii::$app->request->post())) {
//        $arrayId = Yii::$app->request->post('selection');
//            foreach($arrayId as $k => $v) {
//                    $modelss = \app\models\hronline\Tblrscoretireage::findOne($v);
//                    $models = new Tblrscobrp(); 
//                    $models->sah = '1';
//                    $models->sah_by = $icno;
//                    $models->icno =  $modelss->ICNO;
//                    $models->status = 1;
//                    $models->status_update_by = $icno;
//                    $models->status_date = date('Y-m-d H:i:s');
//                    $models->sah_date = date('Y-m-d H:i:s');
//                    $models->data_source = "tblrscoretireage";
//                    $models->remark = 'OPSYEN UMUR PERSARAAN PAKSA DI BAWAH PEKELILING PERKHIDMATAN BILANGAN 11 TAHUN 2011"
//                                      Telah memilih untuk Kekal bersara paksa apabila mencapai umur '.$modelss->RetireAgeCd ." ". 'tahun dan tertakluk kepada Akta Pencen 1980 [Akta 227] dibaca bersama Akta Pencen (Pindaan) 2011 / Akta Pencen Pihak Berkuasa Berkanun Dan Tempatan 1980 [Akta 239] dibaca bersama Akta Pencen Pihak Berkuasa Berkanun Dan Tempatan (Pindaan) 2011**, tertakluk kepada semua peruntukan Akta Pindaan tersebut.';
//                    if  ($modelss->RetireAgeCd == 55) {
//                        $models->brpCd = 27;
//                        $models->save(false);
//                    }
//                    if  ($modelss->RetireAgeCd == 56) {
//                        $models->brpCd = 28;
//                        $models->save(false);
//                    }
//                    if  ($modelss->RetireAgeCd == 58) {
//                        $models->brpCd = 29;
//                        $models->save(false);
//                    }
//                    if  ($modelss->RetireAgeCd == 60) {
//                        $models->brpCd = 30;
//                        $models->save(false);
//                    }
////                    $models->t_lpg_id = $modelss->id;
//                    $models->jawatan_id = $tambah->jawatan_id;
//                    $models->tarikh_mulai = $tambah->tarikh_mulai;
//                    $models->tarikh_hingga = $tambah->tarikh_hingga;
//                    $models->tarikh_lulus = $tambah->tarikh_lulus;
//                    $models->rujukan_surat = $tambah->rujukan_surat;
//                    $models->tarikh_surat = $tambah->tarikh_surat;
//                    $models->isPencen = $tambah->isPencen;
//                    $models->gaji_sebulan = $tambah->gaji_sebulan;
//                    ($models->save(false)); 
//                    
//                }
//                
//             Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod Telah Disahkan!']);
//             return $this->redirect(['brp/view-rekod-bersara', 'ICNO' => $model->ICNO]);
//             
//       }
//      
//        return $this->render('view-rekod-bersara', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider, 
//            'model' => $model, 
//            'tambah' => $tambah,
//            'dataProvider2'=> $dataProvider2      
//        ]);
//    }
 
       public function actionBook($ICNO){
       $maklumat = Tblrscobrp::find()->where(['icno' => $ICNO])->orderBy(['brp_id' => SORT_DESC])->all();//cari semua mesyuarat
       $nama = Tblprcobiodata::find()->where(['ICNO' => $ICNO])->one();
       $waris =Tblkeluarga::find()->where(['ICNO' => $ICNO])->all();
       $pengalaman = Tblpengalamankerja::find()->where(['ICNO' => $ICNO])->one();
       $sijil = Tblpendidikan::find()->where(['ICNO' => $ICNO])->all();
       $pencen = Tblrscopsnstatus::find()->where(['ICNO' => $ICNO])->orderBy(['id' => SORT_DESC])->one();
       $bersara = Tblretireage::find()->where(['ICNO' => $ICNO])->one();
       
       $total_maklumat = count($maklumat);
       $max_per_page = 4;
       $max_first_page = 3;
       $additional_page = 0;
       $bal = 0;
       
       if($total_maklumat <= $max_first_page){
           $additional_page = 1;
       }else{
           $bal_maklumat = $total_maklumat - $max_first_page;
           
           $additional_page = ($bal_maklumat/$max_per_page);
           $bal = $bal_maklumat%$max_per_page; 
           
           if($bal > 0){
              $additional_page++;
           }
           
       }
        $this->layout = 'eBook2';
   
        return $this->render('testing', [ 'maklumat'=> $maklumat, 'nama'=> $nama, 'waris' => $waris,
            'pengalaman' => $pengalaman, 'sijil' => $sijil, 'pencen' => $pencen, 'bersara' => $bersara,
            'additional_page' => $additional_page, 'max_per_page' => $max_per_page, 'max_first_page' => $max_first_page,
            'total_maklumat' => $total_maklumat
                ]);
    }
    
       public function actionBrpPegawai(){
       $ICNO =  Yii::$app->user->getId();
       $maklumat = Tblrscobrp::find()->where(['icno' => $ICNO])->orderBy(['brp_id' => SORT_DESC])->all();//cari semua mesyuarat
       $nama = Tblprcobiodata::find()->where(['ICNO' => $ICNO])->one();
       $waris =Tblkeluarga::find()->where(['ICNO' => $ICNO])->all();
       $pengalaman = Tblpengalamankerja::find()->where(['ICNO' => $ICNO])->one();
       $sijil = Tblpendidikan::find()->where(['ICNO' => $ICNO])->all();
       $pencen = Tblrscopsnstatus::find()->where(['ICNO' => $ICNO])->orderBy(['id' => SORT_DESC])->one();
       $bersara = Tblretireage::find()->where(['ICNO' => $ICNO])->one();
       
       $total_maklumat = count($maklumat);
       $max_per_page = 4;
       $max_first_page = 3;
       $additional_page = 0;
       $bal = 0;
       
       if($total_maklumat <= $max_first_page){
           $additional_page = 1;
       }else{
           $bal_maklumat = $total_maklumat - $max_first_page;
           
           $additional_page = ($bal_maklumat/$max_per_page);
           $bal = $bal_maklumat%$max_per_page; 
           
           if($bal > 0){
              $additional_page++;
           }
           
       }
        $this->layout = 'eBook2';
   
        return $this->render('brp-pegawai', [ 'maklumat'=> $maklumat, 'nama'=> $nama, 'waris' => $waris,
            'pengalaman' => $pengalaman, 'sijil' => $sijil, 'pencen' => $pencen, 'bersara' => $bersara,
            'additional_page' => $additional_page, 'max_per_page' => $max_per_page, 'max_first_page' => $max_first_page,
            'total_maklumat' => $total_maklumat
                ]);
    }
    
         public function actionBukuRekod($ICNO) {
              $model2 = \app\models\hronline\Umsper::find()->where(['ICNO' => $ICNO])->one();
         $maklumat = Tblrscobrp::find()->where(['icno'=> $ICNO])->orderBy(['brp_id' => SORT_ASC])->all();
         $nama = Tblprcobiodata::find()->where(['ICNO' => $ICNO])->one();
         $waris =Tblkeluarga::find()->where(['ICNO' => $ICNO])->all();
         $pengalaman = Tblpengalamankerja::find()->where(['ICNO' => $ICNO])->all();
         $sijil = Tblpendidikan::find()->where(['ICNO' => $ICNO])->all();   
         $pencen = Tblrscopsnstatus::find()->where(['ICNO' => $ICNO])->orderBy(['id' => SORT_DESC])->one();
         $bersara = Tblretireage::find()->where(['ICNO' => $ICNO])->one();
         $anugerah = Tblrscobrp::find()->where(['icno' => $ICNO])->andFilterWhere(['or', ['=', 'brpCd','20'],['=', 'brpCd','21'], ['=', 'brpCd','22'],['=', 'brpCd','23']])->all();
         $model = Tblrscobrp::find()->where(['icno'=> $ICNO])->orderBy(['tarikh_mulai' => SORT_ASC])->all();
         $kwsp = \app\models\vhrms\StaffAccount::find()->where(['SA_STAFF_ID' => $nama->COOldID])->andFilterWhere(['or', ['=', 'SA_ACCT_NAME','KWSP']])->one();
         $kwap = \app\models\vhrms\StaffAccount::find()->where(['SA_STAFF_ID' => $nama->COOldID])->andFilterWhere(['or', ['=', 'SA_ACCT_NAME','KWAP']])->one();
         $cukai = \app\models\vhrms\StaffAccount::find()->where(['SA_STAFF_ID' => $nama->COOldID])->andFilterWhere(['or', ['=', 'SA_ACCT_NAME','LHDN']])->one();
         $akaun = \app\models\vhrms\StaffAccount::find()->where(['SA_STAFF_ID' => $nama->COOldID])->andFilterWhere(['or', ['=', 'SA_ACCT_NAME','SALARY']])->one();
        
         return $this->render('buku-rekod', ['ICNO' => $ICNO,'maklumat' => $maklumat, 'nama'=> $nama,'waris' => $waris,'anugerah' => $anugerah,'model2' => $model2,
                              'pengalaman' => $pengalaman  , 'sijil' => $sijil, 'pencen' => $pencen, 'bersara' => $bersara, 'model' => $model, 'kwsp' => $kwsp, 'kwap' => $kwap, 'cukai' => $cukai, 'akaun'=> $akaun
      
         ]);
    }

      public function actionCetakBrp($ICNO){ 
       $maklumat = Tblrscobrp::find()->where(['icno' => $ICNO])->orderBy(['tarikh_mulai' => SORT_ASC])->all();//cari semua mesyuarat
       $nama = Tblprcobiodata::find()->where(['ICNO' => $ICNO])->one();
       $waris =Tblkeluarga::find()->where(['ICNO' => $ICNO])->all();
       $pengalaman = Tblpengalamankerja::find()->where(['ICNO' => $ICNO])->orderBy(['PrevEmpStartDt' => SORT_DESC])->all();
       $pencen = Tblrscopsnstatus::find()->where(['ICNO' => $ICNO])->orderBy(['id' => SORT_DESC])->one();
       $sijil = Tblpendidikan::find()->where(['ICNO' => $ICNO])->orderBy(['ConfermentDt' => SORT_DESC])->all();
       $bersara = Tblretireage::find()->where(['ICNO' => $ICNO])->one();
       $anugerah = Tblrscobrp::find()->where(['icno' => $ICNO])->andFilterWhere(['or', ['=', 'brpCd','20'],['=', 'brpCd','21'], ['=', 'brpCd','22'],['=', 'brpCd','23']])->all();
       $kwsp = \app\models\vhrms\StaffAccount::find()->where(['SA_STAFF_ID' => $nama->COOldID])->andFilterWhere(['or', ['=', 'SA_ACCT_NAME','KWSP']])->one();
       $kwap = \app\models\vhrms\StaffAccount::find()->where(['SA_STAFF_ID' => $nama->COOldID])->andFilterWhere(['or', ['=', 'SA_ACCT_NAME','KWAP']])->one();
       $cukai = \app\models\vhrms\StaffAccount::find()->where(['SA_STAFF_ID' => $nama->COOldID])->andFilterWhere(['or', ['=', 'SA_ACCT_NAME','LHDN']])->one();
       $akaun = \app\models\vhrms\StaffAccount::find()->where(['SA_STAFF_ID' => $nama->COOldID])->andFilterWhere(['or', ['=', 'SA_ACCT_NAME','SALARY']])->one();
       
       $css = file_get_contents('./css/cetakBrp.css');
             
       $content = $this->renderPartial('_contoh', [ 'kwsp' => $kwsp, 'kwap' => $kwap, 'cukai'=> $cukai, 'akaun' => $akaun, 'maklumat'=> $maklumat, 'nama'=> $nama, 'waris' => $waris, 'anugerah'=> $anugerah, 'pengalaman' => $pengalaman, 'sijil' => $sijil, 'pencen' => $pencen, 'bersara' => $bersara]);

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
            'options' => ['title' => 'Nota Serah Tugas'],
            // call mPDF methods on the fly
              
         
            'methods' => [
          //    'SetHeader' => ['Buku Rekod Perkhidmatan'],
                     'SetFooter' => ["Mukasurat {PAGENO} / {nb}"],
                     'WriteHTML' => [$css, 1]
             
            ]
        ]);
      
        // return the pdf output as per the destination setting
        return $pdf->render();
    }
    
    protected function findModel($id) {
        if (($model = Tblprcobiodata::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionTambahAdmin() {
        $icno = Yii::$app->user->getId();
        $model = StafAkses::findOne(['staf_akses_icno' => $icno]);
         if(!$model){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['brp/index']);
        }
        $admin = StafAkses::find()->All(); //cari senarai admin
        $adminbaru = new StafAkses(); //untuk admin baru
        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
        if ($adminbaru->load(Yii::$app->request->post())) {
                    if(StafAkses::find()->where(['staf_akses_icno' => $adminbaru->staf_akses_icno] )->exists()){ //jika admin sudah wujud
                        Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Sudah Ditambah Sebelum Ini!']);
                    
                    }
                    elseif($adminbaru->kakitangan->CONm != NULL){ //jika icno tidak wujud dalam sistem
                        $adminbaru->staf_akses_id = 99;
                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
                     //    $this->notification('PTB', 'Tahniah anda menjadi Admin untuk Sistem Pertukaran Tempat Bertugas.', $adminbaru->staf_akses_icno);
                      $adminbaru->save();
                    }
                    else{
                        Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Tidak Wujud Dalam Sistem!']);
                    
                    }
                    
                    return $this->redirect(['brp/tambah-admin']);
                }
        if(StafAkses::find()->where(['staf_akses_icno' => Yii::$app->user->getId() ] )->exists()){
        return $this->render('tambah-admin', [
            'admin' => $admin,
            'adminbaru' => $adminbaru,
            'allbiodata' => $allbiodata,
        ]);}
    }
    
    public function actionDeleteAdmin($staf_akses_icno){
        $admin = StafAkses::findOne(['staf_akses_icno' => $staf_akses_icno]);
        $admin->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dipadam']);
        return $this->redirect(['tambah-admin']);
        
    }
    
      public function actionJenisBrp() {
     
        $searchModel = new \app\models\brp\BrpSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->orderBy([           
          'brpCd' => SORT_ASC,   
           ]);
       

        return $this->render('jenis-brp', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel
        ]); 
    }
    
       public function actionTambahJenisBrp(){  
        $tambah = new Brp();
        $listdata = ArrayHelper::map(Brp::find()->all(), 'brpCd', 'brpTitle');
        
           if ($tambah->load(Yii::$app->request->post()) && $tambah->save()) {
            
  
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya disimpan']); 
            return $this->redirect(['jenis-brp']);
        } 
        return $this->render('tambah-jenis-brp', ['tambah' => $tambah, 'listdata' => $listdata]); 
      } 
      
      
      
        public function actionKemaskiniJenisBrp($id){  
        $kemaskini = Brp::find()->where(['brpCd' => $id])->one();
        $listdata = ArrayHelper::map(Brp::find()->all(), 'brpCd', 'brpTitle');
        
           if ($kemaskini->load(Yii::$app->request->post()) && $kemaskini->save()) {
            
  
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod Berjaya Dikemaskini']); 
            return $this->redirect(['jenis-brp']);
        } 
        return $this->render('kemaskini-jenis-brp', ['kemaskini' => $kemaskini, 'listdata' => $listdata]); 
      } 
    
    
       public function actionPadamJenisBrp($id) {
        $model = Brp::find()->where(['brpCd' => $id])->one();
        $model->delete();
        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Rekod Berjaya Dipadam']);

        return $this->redirect(['jenis-brp']);
    }

}
