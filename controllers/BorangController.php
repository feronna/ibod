<?php
namespace app\controllers;
use Yii;
use app\models\Kemudahan\Borang;
use app\models\Kemudahan\BorangSearch;
use app\models\Notification;
use app\models\Kemudahan\Refpegawai;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use app\models\Kemudahan\Borangehsan;
use kartik\mpdf\Pdf;
use yii\helpers\ArrayHelper;
use app\models\kemudahan\Tblaccess;
use app\models\Kemudahan\Kemudahan;
use tebazil\runner\ConsoleCommandRunner;
use yii\filters\AccessControl;
use app\models\kemudahan\TblPayinstruct;
use app\models\kemudahan\TblPayInstructDetails; 
use app\models\kemudahan\Borangwilayah;
use app\models\kemudahan\Boranguniform;
use app\models\kemudahan\Boranglesen;

/**
 * MohonkemudahanController implements the CRUD actions for Mohonkemudahan model.
 */
class BorangController extends Controller
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
    
     protected function ICNO() {
        return Yii::$app->user->getId();
    }
    
    protected function findModel($id)
    {
        if (($model = Borang::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    } 
    protected function findBiodata($ICNO) {
        return Tblprcobiodata::findOne(['ICNO' => $ICNO]);
    }
    
    public function actionFormIndex()
    {  
          
        $model = new Borang();
        
        return $this->render('form_index', [
            'model' => $model, 
            'bil' => 1,
            
        ]);
    }
    public function actionMohon_elaun()
    {
         
//        $facility = new Kemudahan();
        $icno = Yii::$app->user->getId();   
        $check = Borang::find()->where('YEAR(entry_date) > YEAR(NOW() - INTERVAL 3 YEAR)')->andWhere(['mohon' => 1 ,'icno' => $icno]);
        $checkApplication = Borang::find()->where(['status_semasa' => 0,'icno' => $icno]);
  
        if($check ->exists()){
             Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda belum layak untuk memohon. Permohonan hanya boleh dibuat sekali dalam 3 tahun']);
           
            return $this->redirect(['borang/sejarahpermohonan']);
        }
         if($checkApplication->exists()){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
            return $this->redirect(['borang/senarai']);
        }

        
        $model = new Borang();
        $searchModel = new BorangSearch(); 
        $query = Borang::find()->where(['icno' =>$icno])->andWhere(['mohon' => 1 ])->orderBy(['entry_date' => SORT_DESC]);
 
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
  
        $model->entry_date = date('Y-m-d H:i:s');
        $model->icno = $icno;
        $model->jeniskemudahan = 3;
        $model->entry_type = 1;
        $model->pengakuan = 1;
        $dept = Tblprcobiodata::findOne(['ICNO' => $icno]); 
        $peg_tadbir = TblAccess::findOne(['admin_post' => 1 ]); 
        $peg_bsm = TblAccess::findOne(['admin_post' => 2]);   
        $file = UploadedFile::getInstance($model, 'file');
        $file2 = UploadedFile::getInstance($model, 'file2');
        
       if($model->load(Yii::$app->request->post())){ 
           
        if($model->negara == 'Indonesia' || $model->negara == 'Singapura' || $model->negara == 'Brunei Darussalam' || $model->negara == 'Philippines' || $model->negara == 'Thailand'
        || $model->negara == 'Taiwan, Province Of China' || $model->negara == 'Hong Kong' || $model->negara == 'Yemen' || $model->negara == 'Sudan' || $model->negara == 'Sri Lanka' || $model->negara == 'Malaysia' ){

        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Negara Adalah Tidak Layak Memohon Elaun Pakaian Panas']);

        return $this->redirect(['borang/mohon_elaun']);
        }else{
         $ntf = new Notification();
         $ntf2 = new Notification();  
          
        $model->status = 'MENUNGGU TINDAKAN';
        $model->status_pp = 'MENUNGGU TINDAKAN';
        $model->status_kj = 'NEW';
        $model->stat_bendahari = 'NEW';
        $model->status_semasa = '0';
        $model->semakan_by = $peg_tadbir->icno;
        $model->peraku_by = $peg_bsm->icno;
         
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
            if ($model->save(false)) {
 
                 $ntf->icno = $peg_tadbir->icno; // peg  penyelia perjawatan
                            $ntf->title = 'Permohonan Kemudahan Atas Talian';
                            $ntf->content = "Permohonan Kemudahan Elaun Pakaian Panas menunggu tindakan semakan anda, Terima kasih.".Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']);
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save();
                          
                         
                     $ntf2->icno = $peg_bsm->icno; // peg perjawatan
                            $ntf2->title = 'Permohonan Kemudahan Atas Talian';
                            $ntf2->content = "Permohonan Kemudahan Elaun Pakaian Panas menunggu tindakan perakuan anda, Terima kasih.".Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']);
                            $ntf2->ntf_dt = date('Y-m-d H:i:s');
                            $ntf2->save();
             } 
             $this->pendingtask($peg_tadbir->icno, 24);
             $this->pendingtask($peg_bsm->icno, 25);
             $this->notification($model->icno, 'Permohonan anda telah dihantar untuk diproses sila semak status permohonan anda.'.Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senarai'], ['class'=>'btn btn-primary btn-sm']));
             Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar.']);
             return $this->redirect(['borang/senarai']);
        }
       }
        return $this->render('mohon_elaun', [
            'model' => $model,
            'searchModel' => $searchModel, 
            'dataProvider' => $DataProvider,
            'bil' => 1,
//            'facility' => $facility,
            
        ]);
    }
    
//    public function actionSenarai()
//    {
//        $icno = Yii::$app->user->getId();
//       
//        $model = new Borang();
//        $searchModel = new BorangSearch();
//        $model->entry_date= date('Y-m-d H:i:s'); 
//        $status = ['NEW', 'DILULUSKAN', 'MENUNGGU TINDAKAN', 'TIDAK DILULUSKAN']; 
//        $wilayah = new Borangwilayah();
//        $wilayahexists = Borangwilayah::find()->where(['icno' => $wilayah->icno, 'letter_type' => 1])->one();
//
//                
//            $query1 = (new \yii\db\Query())
//                ->select("jeniskemudahan, entry_date, icno, status, status_pp, status_kj, stat_bendahari, isActive2, id")
//                ->from('utilities.fac_tbl_elaun')
//                ->where(['icno' => $icno])
//                ->andWhere(['status_kj'=> $status]) ;
//// 
////            $query2 = (new \yii\db\Query())
////                ->select("jeniskemudahan, entry_date , icno, status_pt, status_pp, status_kj, stat_bendahari, isActive2, id")
////                ->from('utilities.fac_tbl_ehsan')
////                ->where(['icno' => $icno])
////                ->andWhere(['status_kj'=> $status]) ;
////            
////            $query3 = (new \yii\db\Query())
////                ->select("jeniskemudahan, entry_date , icno, status_pt, status_pp, status_kj, stat_bendahari, isActive2, id")
////                ->from('utilities.fac_tbl_perpindahan')
////                ->where(['icno' => $icno])
////                ->andWhere(['status_kj'=> $status]) ;
////            
////            $query4 = (new \yii\db\Query())
////                ->select("jeniskemudahan, entry_date , icno, status_pt, status_pp, status_kj, stat_bendahari, isActive2, id")
////                ->from('utilities.fac_tbl_yuran')
////                ->where(['icno' => $icno])
////                ->andWhere(['status_kj'=> $status]) ;
////            
////            $query5 = (new \yii\db\Query())
////                ->select("jeniskemudahan, entry_date , icno, status_pt, status_pp, status_kj, stat_bendahari, isActive2, id")
////                ->from('utilities.fac_tbl_alat')
////                ->where(['icno' => $icno])
////                ->andWhere(['status_kj'=> $status]) ;
////             $query6 = (new \yii\db\Query())
////                ->select("jeniskemudahan, entry_date , icno, status_pt, status_pp, status_kj, stat_bendahari, isActive2, id")
////                ->from('utilities.fac_tbl_lesen')
////                ->where(['icno' => $icno])
////                ->andWhere(['status_kj'=> $status]) ;
////             $query7 = (new \yii\db\Query())
////                ->select("jeniskemudahan, entry_date , icno, status_pt, status_pp, status_kj, stat_bendahari, isActive2, id")
////                ->from('utilities.fac_tbl_pasport')
////                ->where(['icno' => $icno])
////                ->andWhere(['status_kj'=> $status]) ;
////              $query8 = (new \yii\db\Query())
////                ->select("jeniskemudahan, entry_date , icno, status_pt, status_pp, status_kj, stat_bendahari, isActive2, id")
////                ->from('utilities.fac_tbl_pakaian')
////                ->where(['icno' => $icno])
////                ->andWhere(['status_kj'=> $status]) ;
////              $query9 = (new \yii\db\Query())
////                ->select("jeniskemudahan, entry_date , icno, status_pt, status_pp, status_kj, stat_bendahari, isActive, id")
////                ->from('utilities.fac_tbl_pengangkutan')
////                ->where(['icno' => $icno])
////                ->andWhere(['status_kj'=> $status]) ;
//              $query10 = (new \yii\db\Query())
//                ->select("jeniskemudahan, entry_date , icno, status_pt, status_pp, status_kj, stat_bendahari, isActive, id")
//                ->from('utilities.fac_tbl_wilayah')
//                ->where(['icno' => $icno])
//                ->andWhere(['status_kj'=> $status]) ;
////              $query11 = (new \yii\db\Query())
////                ->select("jeniskemudahan, entry_date , icno, status_pt, status_pp, status_kj, stat_bendahari, isActive2, id")
////                ->from('utilities.fac_tbl_uniform')
////                ->where(['icno' => $icno])
////                ->andWhere(['status_pp'=> 'TIDAK LENGKAP', 'jeniskemudahan' => '11','status_pp'=> $status2]) ;
//            
//            
////            $query1->union($query2, false);//false is UNION, true is UNION ALL
////            $query1->union($query3, false);//false is UNION, true is UNION ALL
////            $query1->union($query4, false);//false is UNION, true is UNION ALL
////            $query1->union($query5, false);//false is UNION, true is UNION ALL
////            $query1->union($query6, false);//false is UNION, true is UNION ALL
////            $query1->union($query7, false);//false is UNION, true is UNION ALL
////            $query1->union($query8, false);//false is UNION, true is UNION ALL
////            $query1->union($query9, false);//false is UNION, true is UNION ALL
//            $query1->union($query10, false);//false is UNION, true is UNION ALL
////            $query1->union($query11, false);//false is UNION, true is UNION ALL
//
//            $sql = $query1->createCommand()->getRawSql();
//            $sql .= ' ORDER BY entry_date DESC';
//            $query = Borang::findBySql($sql);
//			
//			
//            $dataProvider = new ActiveDataProvider([
//                'query' => $query,              
//            ]);
//  
//         return $this->render('senarai', [
//            'model' => $model,
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider, 
//            'bil' => 1,
//            'wilayahexists' => $wilayahexists,
//        ]);
//    } 
      public function actionSenarai()
    {
        $icno = Yii::$app->user->getId(); 
        $model = new Borangwilayah(); 
        $status = ['NEW', 'DILULUSKAN', 'MENUNGGU TINDAKAN', 'TIDAK DILULUSKAN']; 
        $status2 = ['NEW', 'DILULUSKAN', 'MENUNGGU TINDAKAN', 'TIDAK DILULUSKAN', 'MENUNGGU KELULUSAN', 'TIDAK LENGKAP']; 
        
        $query = Borangwilayah::find()->where(['icno' => $icno, 'status_kj' => $status])->orderBy(['entry_date' => SORT_DESC]);

        $wilayahCount = Borangwilayah::find()->where(['icno' => $model->icno])->andWhere(['mohon' => 1])->all();    
        $count = count($wilayahCount);
        
        $query2 = Boranguniform::find()->where(['icno' => $icno])->andwhere(['status_pp'=> 'TIDAK LENGKAP', 'jeniskemudahan' => '11','status_pp'=> $status2]);
       
        $exst = Borangwilayah::find()->where(['icno' => $icno])->andWhere(['letter_type' => 1])->one();
 
        $query3 = Boranglesen::find()->where(['icno' => $icno, 'status_kj' => $status])->orderBy(['entry_date' => SORT_DESC]);

        $query4 = Borang::find()->where(['icno' => $icno, 'status_kj' => $status])->orderBy(['entry_date' => SORT_DESC]);
        
            $dataProvider = new ActiveDataProvider([
                'query' => $query,              
            ]);
            
            $dataProvider2 = new ActiveDataProvider([
                'query' => $query2,              
            ]);

            $lesen = new ActiveDataProvider([
                'query' => $query3,              
            ]);

            $pakaianPanas = new ActiveDataProvider([
                'query' => $query4,              
            ]);
  
         return $this->render('senarai', [
            'model' => $model, 
            'dataProvider' => $dataProvider,
            'dataProvider2' => $dataProvider2, 
            'bil' => 1,
            'wilayahCount' => $wilayahCount,
            'exst' => $exst,
            'count' => $count,
            'lesen' => $lesen,
            'pakaianPanas' => $pakaianPanas,
        ]);
    } 
    
     public function actionSejarahpermohonan()
    {
        $icno = Yii::$app->user->getId();
       
        $model = new Borang();
        $searchModel = new BorangSearch();
        $model->entry_date= date('Y-m-d H:i:s');
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
         $status2 = ['NEW', 'DILULUSKAN', 'MENUNGGU TINDAKAN', 'TIDAK DILULUSKAN', 'MENUNGGU KELULUSAN', 'TIDAK LENGKAP']; 
         
        
            $query1 = (new \yii\db\Query())
                ->select("jeniskemudahan, entry_date, icno, status, status_pp, status_kj, stat_bendahari, isActive2, id")
                ->from('utilities.fac_tbl_elaun')
                ->where(['icno' => $icno])
                ->andWhere(['isActive2'=> 1]) ;
// 
//            $query2 = (new \yii\db\Query())
//                ->select("jeniskemudahan, entry_date , icno, status_pt, status_pp, status_kj, stat_bendahari, isActive2, id")
//                ->from('utilities.fac_tbl_ehsan')
//                ->where(['icno' => $icno])
//                ->andWhere(['mohon'=> 1]) ;
//            
//            $query3 = (new \yii\db\Query())
//                ->select("jeniskemudahan, entry_date , icno, status_pt, status_pp, status_kj, stat_bendahari, isActive2, id")
//                ->from('utilities.fac_tbl_perpindahan')
//                ->where(['icno' => $icno])
//                ->andWhere(['mohon'=> 1]) ;
//            
//            $query4 = (new \yii\db\Query())
//                ->select("jeniskemudahan, entry_date , icno, status_pt, status_pp, status_kj, stat_bendahari, isActive2, id")
//                ->from('utilities.fac_tbl_yuran')
//                ->where(['icno' => $icno])
//                 ->andWhere(['mohon'=> 1]) ;
//            
//            $query5 = (new \yii\db\Query())
//                ->select("jeniskemudahan, entry_date , icno, status_pt, status_pp, status_kj, stat_bendahari, isActive2, id")
//                ->from('utilities.fac_tbl_alat')
//                ->where(['icno' => $icno])
//                ->andWhere(['mohon'=> 1]) ;
//             $query6 = (new \yii\db\Query())
//                ->select("jeniskemudahan, entry_date , icno, status_pt, status_pp, status_kj, stat_bendahari, isActive2, id")
//                ->from('utilities.fac_tbl_lesen')
//                ->where(['icno' => $icno])
//                ->andWhere(['mohon'=> 1]) ;
//             $query7 = (new \yii\db\Query())
//                ->select("jeniskemudahan, entry_date , icno, status_pt, status_pp, status_kj, stat_bendahari, isActive2, id")
//                ->from('utilities.fac_tbl_pasport')
//                ->where(['icno' => $icno])
//                 ->andWhere(['mohon'=> 1]) ;
//              $query8 = (new \yii\db\Query())
//                ->select("jeniskemudahan, entry_date , icno, status_pt, status_pp, status_kj, stat_bendahari, isActive2, id")
//                ->from('utilities.fac_tbl_pakaian')
//                ->where(['icno' => $icno])
//                ->andWhere(['mohon'=> 1]) ;
             $query10 = (new \yii\db\Query())
                ->select("jeniskemudahan, entry_date , icno, status_pt, status_pp, status_kj, stat_bendahari, isActive, id")
                ->from('utilities.fac_tbl_wilayah')
                ->where(['icno' => $icno])
                ->andWhere(['isActive'=> 1]) ;
//              $query11 = (new \yii\db\Query())
//                ->select("jeniskemudahan, entry_date , icno, status_pt, status_pp, status_kj, stat_bendahari, isActive2, id")
//                ->from('utilities.fac_tbl_uniform')
//                ->where(['icno' => $icno])
//                ->andWhere(['status_pp'=> 'TIDAK LENGKAP', 'jeniskemudahan' => '11','status_pp'=> $status2]) ;
              
              
//            $query1->union($query2, false);//false is UNION, true is UNION ALL
//            $query1->union($query3, false);//false is UNION, true is UNION ALL
//            $query1->union($query4, false);//false is UNION, true is UNION ALL
//            $query1->union($query5, false);//false is UNION, true is UNION ALL
//            $query1->union($query6, false);//false is UNION, true is UNION ALL
//            $query1->union($query7, false);//false is UNION, true is UNION ALL
//            $query1->union($query8, false);//false is UNION, true is UNION ALL
            $query1->union($query10, false);//false is UNION, true is UNION ALL
//            $query1->union($query11, false);//false is UNION, true is UNION ALL

            $sql = $query1->createCommand()->getRawSql();
            $sql .= ' ORDER BY entry_date DESC';
            $query = Borang::findBySql($sql);
			
			
            $dataProvider = new ActiveDataProvider([
                'query' => $query,              
            ]);
 
         return $this->render('sejarah_permohonan', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
 
            'bil' => 1,
        ]);
    }    
     
    public function actionSemakan_bsm($id)
    {
        $icno = Yii::$app->user->getId();
         
        $model = $this->findModel($id);
     
        $searchModel = new BorangSearch();
        $query = Borang::find()->where(['mohon' => 1]) ->andWhere(['icno' => $model->icno])->orderBy(['entry_date' => SORT_DESC]);
 
        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $model->review_date = date('Y-m-d H:i:s');
        $model->status_pp = 'MENUNGGU KELULUSAN';
        $model->stat_bendahari = 'ENTRY';
        
        if(Tblaccess::find()->where( ['icno' => $icno] )->andWhere(['admin_post' => [2,3,4]])->exists()){              
             Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
             return $this->redirect(['kemudahan/index']);
        }
        elseif(TblAccess::find()->where(['icno' => $icno])->andWhere(['admin_post' => 6])->exists()){ 
           Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']); 
           return $this->redirect(['boranguniform/senaraitindakan']); 
        
        }

        if ($model->load(Yii::$app->request->post())) {
            if($model->status == ''){
               Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan form']); 
            
                }
                else{
                $model->semakan_by = $icno;
                $model->save(false); 
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
                return $this->redirect(['borang/senaraitindakan']);
                }
        }
        return $this->render('semakan_bsm', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]);
       
    } 
     public function actionTindakan_bsm($id)
    {
        $icno = Yii::$app->user->getId();
         
        $model = $this->findModel($id); 
        $chief = Department::findOne(['id' => '158']); 
        $searchModel = new BorangSearch(); 
 
        $query = Borang::find()->where(['mohon' => 1]) ->andWhere(['icno' => $model->icno])->orderBy(['entry_date' => SORT_DESC]);
 
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $model->ver_date = date('Y-m-d H:i:s');
        $model->status_kj = 'MENUNGGU TINDAKAN';
        $model->stat_bendahari = 'MENUNGGU TINDAKAN';
         
        if(Tblaccess::find()->where( ['icno' => $icno] )->andWhere(['admin_post' => [1,3,4]])->exists()){              
             Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
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
                            $ntf->content = "Permohonan Kemudahan Elaun Pakaian Panas menunggu tindakan Kelulusan anda, Terima Kasih".Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senaraitindakan'], ['class'=>'btn btn-primary btn-sm']);
                            $ntf->ntf_dt = date('Y-m-d H:i:s');
                            $ntf->save(); 
                $model->pelulus_by = $chief->chief;
                $model->peraku_by = $icno;          
                $model->save(false);    
                $this->pendingtask($chief->chief, 27);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
                return $this->redirect(['borang/senaraitindakan']);
                }
        }
        
       
        return $this->render('tindakan_bsm', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]);
    }
     
    public function actionTindakan_kj($id)
    {
        $icno = Yii::$app->user->getId();           
        $model = $this->findModel($id);
        $pay = new TblPayinstruct();
        $infoPay = new TblPayInstructDetails(); 
        $chief = Department::find()->where(['chief' => $icno, 'id' => '158'])->exists(); 
        $peg_bsm = TblAccess::findOne(['admin_post' => 2]);   
        
        $searchModel = new BorangSearch();
        $query = Borang::find()->where(['mohon' => 1])->andWhere(['icno' => $model->icno])->orderBy(['entry_date' => SORT_DESC]);
 
        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
 
        
        $model->isActive2 = '2';
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
                $ntf2 = new Notification(); 

                $ntf2->icno = $model->icno; // pemohon
                $ntf2->title = 'Permohonan Kemudahan Atas Talian';
                $ntf2->content = "Permohonan Kemudahan Elaun Pakaian Panas anda tidak diluluskan.".Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senarai'], ['class'=>'btn btn-primary btn-sm']);
                $ntf2->ntf_dt = date('Y-m-d H:i:s');
                $ntf2->save();     
                
                $model->pelulus_by = $icno; 
                $model->save(false);   
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
                return $this->redirect(['borang/senaraitindakan']);
                
            }
            else{
            
            $model->isActive2 ='1'; 
            $model->stat_bendahari = 'MENUNGGU KELULUSAN';
            $model->send_date = date('Y-m-d H:i:s');  
            
            //tindakan bendahari
            $model->jumlah = '1500.00';
            $model->mohon = '1'; 
            $model->status_semasa = '1';            
            $model->pelulus_by = $icno;     
            
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
  
            $model->save(false);   
            $pay->save(false); 
            $infoPay->save(false); 
            $this->notification($model->icno, "Permohonan anda telah diluluskan. Sila semak permohonan anda di senarai permohonan, Terima Kasih"." ".Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senarai'], ['class'=>'btn btn-primary btn-sm']));
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
            return $this->redirect(['borang/senaraitindakan']);
            }
        }
        
        return $this->render('tindakan_kj', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
            'pay' => $pay,
            'infoPay' => $infoPay,
            'bil' => 1,
        ]);
    } 
     public function actionSenaraiberjaya()
    {
       
        $model = new Borang();
        $pay = new TblPayinstruct();
        $infoPay = new TblPayInstructDetails(); 
        $model->icno = Yii::$app->user->getId();
        $peg_bendahari = TblAccess::findOne(['admin_post' => 4]);   
        $searchModel = new BorangSearch();
        $status = ['DILULUSKAN']; 
        $models = Borang::find()->All();
        $selection=(array)Yii::$app->request->post('selection');//typecasting
        $query = Borang::find()->where([ 'status_kj' => $status]) ->andWhere(['isActive2' => 2]);
        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if(TblAccess::find()->where(['icno' => $model->icno])->andWhere(['admin_post' => 7, 'isActive' => 1])->exists()){
           return $this->redirect(['boranguniform/senaraiberjaya']);

        }  
        
            if (Yii::$app->request->post('simpan')){ 

                $ntf = new Notification();  
                foreach ($selection as $id) {   
                    $model = $this->findModel($id); 
                    $pay = new TblPayinstruct();  
                    $infoPay = new TblPayInstructDetails(); 
                    if('y'.$id == Yii::$app->request->post($id)){
                    $model->isActive2 ='1'; 
                    $model->stat_bendahari = 'MENUNGGU KELULUSAN';
                    $model->send_date = date('Y-m-d H:i:s');  
                    
                    //tindakan bendahari
                    $model->jumlah = '1500.00';
                    $model->mohon = '1'; 
                    $model->status_semasa = '1';
                    
                  
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
                     
                    //  $ntf->icno = $peg_bendahari->icno; // notification kpd bendahari
                    //         $ntf->title = 'Permohonan Kemudahan Atas Talian';
                    //         $ntf->content = "Permohonan Elaun Pakaian Panas menunggu tindakan anda untuk diproses.".Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senaraibendahari'], ['class'=>'btn btn-primary btn-sm']);;
                    //         $ntf->ntf_dt = date('Y-m-d H:i:s');
                    //         $ntf->save();
                     
                    $this->notification($model->icno, "Permohonan anda telah diluluskan. Sila semak permohonan anda di senarai permohonan, Terima Kasih"." ".Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senarai'], ['class'=>'btn btn-primary btn-sm']));
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
            
        return $this->render('senarai_berjaya', [
            'model' => $model,
            'models' => $models,
            'pay' => $pay,
            'infoPay' => $infoPay,
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]);
    }
        public function actionSkelulusan($id)
        {  
            $css = file_get_contents('./css/esurat.css');
            #cehck application
            $model = $this->findModel($id);
            $icno = Yii::$app->user->getId();  
            $facility = Borang::find()->where(['icno' => $icno])->andWhere(['id' =>  $id])->one(); 
            $content = $this->renderPartial('skelulusan', ['facility'=> $facility]);
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
        public function actionSk_lulus($id)
        {   $css = file_get_contents('./css/esurat.css');
            #cehck application
            $model = $this->findModel($id);
            $icno = Yii::$app->user->getId();   
            $facility2 = Borang::find()->where(['icno' => $model])->andWhere(['id' =>  $id])->one();
     //     get your HTML raw content without any layouts or scripts
            $content = $this->renderPartial('sk_lulus', ['facility2' => $facility2 ]);
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
        public function actionMemo($id)
        {   $css = file_get_contents('./css/memo.css');
            #cehck application
            $model = $this->findModel($id);
            $icno = Yii::$app->user->getId();  
            $facility = Borang::find()->where(['icno' => $model])->andWhere(['id' =>  $id])->one(); 
          //   $facility2 = Borang::find()->where(['icno' => $icno])->one();
            $content = $this->renderPartial('memo', ['facility'=> $facility]);
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
        
    public function actionSurat_kj($id)
        {   $css = file_get_contents('./css/kelulusan.css');
            #cehck application
            $model = $this->findModel($id);
            $icno = Yii::$app->user->getId();  
            $facility = Borang::find()->where(['icno' => $model])->andWhere(['id' =>  $id])->one(); 
          //   $facility2 = Borang::find()->where(['icno' => $icno])->one();
            $content = $this->renderPartial('surat_kj', ['facility'=> $facility]);
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
        
    public function actionSenaraibendahari()
    {
       
        $icno = Yii::$app->user->getId();
         
        if(Tblaccess::find()->where( ['icno' => $icno] )->andWhere(['admin_post' => [1,2,3]])->exists()){              
             Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
             return $this->redirect(['kemudahan/index']);
        }
        
        $searchModel = new BorangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $status = ['DILULUSKAN'];
        $model = Borang::find()->where(['in', 'status_kj', $status])->andWhere(['isActive2' => 1])->orderBy(['entry_date' => SORT_DESC])->All();
   
        
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
      

        $searchModel = new BorangSearch();
        
        $query = Borang::find()->where(['mohon' => 1]) ->andWhere(['icno' => $model->icno])->orderBy(['entry_date' => SORT_DESC]);
        
        $DataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
       
       $model->jumlah = '1500.00';
       $model->mohon = '1';
       $model->bendahari_date = date('Y-m-d H:i:s'); 
       
        if(Tblaccess::find()->where( ['icno' => $icno] )->andWhere(['admin_post' => [1,2,3]])->exists()){              
             Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
             return $this->redirect(['kemudahan/index']);
        }
          
        return $this->render('tindakan_bendahari', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $DataProvider,
            'bil' => 1,
        ]);
    }
    
     public function actionSenaraitindakan()
    {
        $icno=Yii::$app->user->getId();
        $title = '';
        $senarai  = '';
        $status = ['NEW', 'DILULUSKAN', 'MENUNGGU TINDAKAN', 'TIDAK DILULUSKAN']; 
//        if(Refpegawai::find()->where( ['pembantu_tadbir' => $icno] )->exists()){
        if(Tblaccess::find()->where( ['icno' => $icno] )->andWhere(['admin_post' => [1,5], 'isActive' => 1])->exists()){              
            $senarai = Borang::find()->where(['in', 'status_kj', $status])->orderBy(['entry_date' => SORT_DESC]);
            $title='Senarai Menunggu Semakan';
            
        }
       
        elseif(Tblaccess::find()->where( ['icno' => $icno] )->andWhere(['admin_post' => [2,5], 'isActive' => 1])->exists()){
            
            $senarai = Borang::find()->where(['in', 'status_kj', $status])->orderBy(['entry_date' => SORT_DESC]);
            $title ='Senarai Menunggu Perakuan';
            
        }
        elseif(Department::find()->where(['chief' => $icno, 'id' => '158'])->exists()){
            
            $senarai = Borang::find()->where(['in', 'status_kj', $status])->orderBy(['entry_date' => SORT_DESC]);
            $title ='Senarai Menunggu Kelulusan';
            
        }  
//        elseif(TblAccess::find()->where(['icno' => $icno])->andWhere(['admin_post' => 6, 'isActive' => 1])->exists()){
        elseif(Department::find()->where(['chief' => Yii::$app->user->getId(), 'isActive' => 1])->exists()){
           return $this->redirect(['boranguniform/senaraitindakan']);

        }
         elseif(TblAccess::find()->where(['icno' => $icno])->andWhere(['admin_post' => 7, 'isActive' => 1])->exists()){
           return $this->redirect(['boranguniform/senaraitindakan']);

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
     public function actionLaporan($carian_icno = null ,$tahun = null, $bulan = null) {
       
        $year = date('Y');
        $mth = date('m');
        $icno = Yii::$app->user->getId();
        $carian = $carian_icno;
        
        if ($tahun != null) {
            $year = $tahun;
        }
        if ($bulan != null) {
            $mth = $bulan;
        }
        $model = new Borang();
       
        if($bulan == 0 ){
         $query =  Borang::find()->where(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->orderBy(['entry_date' => SORT_ASC]);
           
        } 
        elseif($bulan != 0 && $carian == NULL){
            $query =  Borang::find()->where(['MONTH(entry_date)' => $mth])->andWhere(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->orderBy(['entry_date' => SORT_ASC]);
        
        }
        else{
            $query =  Borang::find()->where(['icno' => $carian_icno])->andWhere(['YEAR(entry_date)' => $year,'mohon' => 1])->orderBy(['entry_date' => SORT_ASC]);

        }
//        else{
//            $query = Borang::find()->where(['icno' => $dept->ICNO]->andWhere(['mohon' => 1])->orderBy(['entry_date' => SORT_ASC]);
//        }
         
        
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
        $model = Borang::find() ->where(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->orderBy(['entry_date' => SORT_ASC])->all();
       
        }else{
        $model = Borang::find() ->where(['YEAR(entry_date)' => $year])->andWhere(['MONTH(entry_date)' => $mth])->andWhere(['mohon' => 1])->orderBy(['entry_date' => SORT_ASC])->all();
      
        }
        
        return $this->render('reportpentadbiran', [
            'tahun' => $year,
            'bulan' => $mth, 
            'model' => $model,
        ]);
    }     
    public function actionLaporanyear( $tahun = null, $bulan = null) {
       
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
        return $this->render('laporanyear', ['tahun' => $year, 'bulan' => $mth, 'dataProvider' => $DataProvider, 
           'model' => $model, 'label' => $label,
           'data' => $data,
           'sum' => $sum,
            ]);
        }
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf',
        'type' => 'error', 'msg' => 'Anda Tidak Mempunyai Akses']);
        return $this->redirect(['kemudahan/index']);

    } 
    public function actionLaporanyear1( $id = null, $tahun = null, $bulan = null) {
       
 
        $year = date('Y');
        $mth = date('m');
     
       if (!$id) {
            $id = Yii::$app->user->getId();
        } 
        if ($tahun != null) {
            $year = $tahun;
        }
        if ($bulan != null) {
            $mth = $bulan;
        } 
        
          
        $model = new Borang(); 
        $query = Borang::find() ->where(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1])->orderBy(['entry_date' => SORT_ASC]);
  
        $dataProvider = new ActiveDataProvider([
        'query' => $query,
            
        ]);
   
        return $this->render('laporanyear1', [ 
            'tahun' => $year, 
            'bulan' => $mth, 
            'dataProvider' => $dataProvider, 
            'model' => $model
                ]);
    } 
      
    public function actionLaporanyear2( $id = null, $tahun = null, $bulan = null) {
       
 
        $year = date('Y');
        $mth = date('m');
       
       if (!$id) {
            $id = Yii::$app->user->getId();
        } 
        if ($tahun != null) {
            $year = $tahun;
        }
        if ($bulan != null) {
            $mth = $bulan;
        } 
           
        $model = new Borang(); 
        $query = Borangehsan::find() ->where(['YEAR(entry_date)' => $year])->andWhere(['mohon' => 1 ])->orderBy(['entry_date' => SORT_ASC]);
    
        $dataProvider = new ActiveDataProvider([
        'query' => $query,
        ]);
      
        return $this->render('laporanyear2', [
           
            'bulan' => $mth, 
            'dataProvider' => $dataProvider, 
            'model' => $model
                ]);
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
    
    public function actionPayment()
    {
         
          $query = TblPayInstructDetails::find()->orderBy(['from' => SORT_DESC]); 
         
          $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
         
        return $this->render('payment', [ 
            'dataProvider' => $dataProvider,   
        ]);
        
    }
    public function actionPay($id)
    {
          $model = $this->findModel($id);

          $query = TblPayInstruct::find()->where(['PAY_PARENT_ID' => $model->id ])->orderBy(['PAY_DATE_FROM' => SORT_DESC]); 
        
          $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); 
          
        return $this->render('pay', [ 
             'dataProvider' => $dataProvider, 
                'model' => $model, 
        ]);
        
    }
    public function actionElaunDetails()
    {
        if (isset($_POST['expandRowKey'])) {
            $model = TblPayinstruct::find()->where(['PAY_REF_ID' => $_POST['expandRowKey']]);
            $dataProvider = new ActiveDataProvider([
                'query' => $model,
                'pagination' => [
                    //'pageSize' => 20,
                    'pageSize' => 5,
                ],
                'sort' => false,
            ]);
            return $this->renderPartial('_elaun2', ['dataProvider' => $dataProvider]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

 
public function actionNewElaun($id)
    {
    
        $model = $this->findModel($id); 
        
        $batch = TblPayInstruct::findOne(['PAY_PARENT_ID' => $model->id]); 
        $query = TblPayInstruct::find()->where(['PAY_PARENT_ID' => $model->id ])->orderBy(['PAY_DATE_FROM' => SORT_DESC]); 
     
          $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
          
           
  
        return $this->renderAjax('new_elaun', [ 'model' => $model, 'batch' => $batch,'dataProvider' => $dataProvider]);
    }

//    public function actionCreateElaun($id) ///lnpt example coding
//    {
//        $model = $this->findModel($id); 
//
//        if ($model->load(Yii::$app->request->post())) {
//            if ($model->save()) {
//                if (Yii::$app->request->isAjax) {
//                    // JSON response is expected in case of successful save
//                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//                    return ['success' => true];
//                }
//                return $this->redirect(['new_elaun', ]);
//            }
//        }
//
//        if (Yii::$app->request->isAjax) {
//            return $this->renderAjax('create_elaun', [
//                'model' => $model,
//            ]);
//        } else {
//            return $this->render('create_elaun', [
//                'model' => $model,
//            ]);
//        }
//    }

     public function actionNewEntry()
    { 
       
        $icno = Yii::$app->user->getId();    
      
        $model = new Borang();
        $peg_bsm = TblAccess::findOne(['admin_post' => 2]); 
        
        $model->entry_date = date('Y-m-d H:i:s'); 
        $model->jeniskemudahan = 3;
        $model->entry_type = 2;
        $model->status_kj = 'DILULUSKAN';
        $model->isActive2 = 2;
        $model->mohon = 1;
        $model->stat_bendahari = 'MENUNGGU TINDAKAN'; 
        $model->status_semasa = 0;
        
        $file = UploadedFile::getInstance($model, 'file');
        $file2 = UploadedFile::getInstance($model, 'file2');
        
       if($model->load(Yii::$app->request->post())){ 
           
        if($model->negara == 'Indonesia' || $model->negara == 'Singapura' || $model->negara == 'Brunei Darussalam' || $model->negara == 'Philippines' || $model->negara == 'Thailand'
        || $model->negara == 'Taiwan, Province Of China' || $model->negara == 'Hong Kong' || $model->negara == 'Yemen' || $model->negara == 'Sudan' || $model->negara == 'Sri Lanka' || $model->negara == 'Malaysia' ){

        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Negara Adalah Tidak Layak Memohon Elaun Pakaian Panas']);

        return $this->redirect(['borang/new-entry']);
        
        }else{ 
         $ntf = new Notification();
         
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
        
        $ntf->icno = $peg_bsm->icno; // peg  penyelia perjawatan
                     $ntf->title = 'Permohonan Kemudahan Atas Talian';
                     $ntf->content = "Permohonan Kemudahan Elaun Pakaian Panas menunggu tindakan daripada anda.".Html::a('<i class="fa fa-arrow-right"></i>', ['borang/senaraiberjaya'], ['class'=>'btn btn-primary btn-sm']);
                     $ntf->ntf_dt = date('Y-m-d H:i:s');
                     $ntf->save(); 
                            
        $model->save(false);
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar.']);
        return $this->redirect(['borang/new-entry']);
        }
       }
        return $this->render('new_entry', [
            'model' => $model, 
            
        ]);
        
        
    }
  
    //delete file yang diupload
    public function actionPadam(){
        return Yii::$app->FileManager->DeleteFile('');//insert the code
        
    }
    protected function pendingtask($icno, $id){
        $runner = new ConsoleCommandRunner();
        $runner->run('dashboard/pending-task-individu', [$icno, $id]);
    }

    
}
