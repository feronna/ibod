<?php

namespace app\controllers;
use app\models\keterhutangan\TblRekod;
use app\models\hronline\Tblprcobiodata;
use Yii;
use kartik\mpdf\Pdf;
use yii\data\ActiveDataProvider;
use app\models\vhrms\ViewPayroll;
use app\models\cuti\SetPegawai;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class KeterhutanganController extends \yii\web\Controller
{
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
    
    public function notification($title, $content, $ic){

        if($ic == null){
            //default user login selalu guna ic   // null if the user not authenticated.    //get userid after login
            $ic = Yii::$app->user->getId();  
        }
        $ntf = new \app\models\Notification();
        $ntf->icno = $ic;  
        $ntf->title = $title;
        $ntf->content = $content;
        $ntf->ntf_dt = date('Y-m-d H:i:s');
        $ntf->save();
        return true;
    }

    
    public function actionMaklumbalasKakitangan(){
    $icno = Yii::$app->user->getId();
    $biodata = TblRekod::find()->where(['icno' => $icno])->one();
    $models = TblRekod::find()->where(['icno' => $icno, 'status_maklumbalas' => null])->all();

     if ($biodata->load(Yii::$app->request->post())) {
         $biodata->tarikh_hantar = date('Y-m-d H:i:s');
         $biodata->status_maklumbalas = 1;
         $biodata->save();
         
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumbalas Berjaya Dihantar']);
        $this->notification('Keterhutangan Kewangan Serius', "Maklumbalas Surat Tunjuk Sebab telah Berjaya Direkodkan.", $biodata->kj); 
        return $this->redirect(['sejarah-maklumbalas-kakitangan']);
        }

        return $this->render('maklumbalas-kakitangan', [
            'biodata' => $biodata, 'models'=>$models
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
    
    public function actionLaporanPemaklumanKedudukanKewanganKakitangan($id) 
    {
        $css = file_get_contents('./css/surat.css');
        $biodata = TblRekod::find()->where(['id' => $id])->one();
        $staf = TblRekod::find()->where(['icno' => $biodata->icno])->one();
       
        if($staf->sesi == 1){
            $sesi_start = $staf->tahun."01";
            $sesi_end = $staf->tahun."04";

        }if($staf->sesi == 2){
            $sesi_start = $staf->tahun."05";
            $sesi_end = $staf->tahun."08";

        }else{
            $sesi_start = $staf->tahun."09";
            $sesi_end = $staf->tahun."12";

        }
        $data = ViewPayroll::find()
                    ->select(['*'])
                   ->where(['between', 'CAST(MPH_PAY_MONTH AS INT)', $sesi_start, $sesi_end])
                   ->andWhere(['LIKE', 'MPDH_INCOME_CODE', 'B1000', false])
                   ->andWhere(['!=', 'MPH_TOTAL_DEDUCTION', 0])
                   ->andWhere(['!=', 'MPH_TOTAL_ALLOWANCE', 0])
                //   ->andWhere('(MPH_TOTAL_DEDUCTION/MPH_TOTAL_ALLOWANCE*100) > 60')
                    ->andWhere('( (MPH_TOTAL_ALLOWANCE - MPH_TOTAL_DEDUCTION) / MPH_TOTAL_ALLOWANCE * 100) < 40')
                   ->andWhere(['sm_ic_no' => $biodata->icno])
                   ->orderBy(['MPH_PAY_MONTH'=>SORT_ASC])
                   ->all();
        
        
        $content = $this->renderPartial('_pemaklumankj', ['biodata'=> $biodata, 'data' => $data, 'staf' => $staf]);

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
    
    
     public function actionDetailView($id){
         
        $request = Yii::$app->request;

        if($request->get('tahun')){

                $sesi = $request->get('sesi');
                $tahun = $request->get('tahun');

                if($sesi == 1){
                    $sesi_start = $tahun."01";
                    $sesi_end = $tahun."04";

                }
                if($sesi == 2){
                    $sesi_start = $tahun."05";
                    $sesi_end = $tahun."08";

                }
                if($sesi == 3){
                    $sesi_start = $tahun."09";
                    $sesi_end = $tahun."12";

                }
                
           

            }else{
                $tahun = "2015";
                $sesi_start = $tahun."01";
                $sesi_end = $tahun."06";
           }

      
        $model = ViewPayroll::find()->where(['sm_ic_no' => $id])->one();
        
        $data = ViewPayroll::find()
                    ->select(['*'])
                   ->where(['between', 'CAST(MPH_PAY_MONTH AS INT)', $sesi_start, $sesi_end])
                   ->andWhere(['LIKE', 'MPDH_INCOME_CODE', 'B1000', false])
                   ->andWhere(['!=', 'MPH_TOTAL_DEDUCTION', 0])
                   ->andWhere(['!=', 'MPH_TOTAL_ALLOWANCE', 0])
               //    ->andWhere('(MPH_TOTAL_DEDUCTION/MPH_TOTAL_ALLOWANCE*100) > 60')
                   ->andWhere('( (MPH_TOTAL_ALLOWANCE - MPH_TOTAL_DEDUCTION) / MPH_TOTAL_ALLOWANCE * 100) < 40')
                   ->andWhere(['sm_ic_no' => $id])
                   ->orderBy(['MPH_PAY_MONTH'=>SORT_ASC])
                   ->all();

        return $this->render('detail-view', [
                    'model' => $model,
                    'data' => $data
        ]);
    }
    
    
        public function actionDetailViewKj($id){      
        $model = ViewPayroll::find()->where(['sm_ic_no' => $id])->one();
        $staf = TblRekod::find()->where(['icno' =>$id])->one();
        if($staf->sesi == 1){
            $sesi_start = $staf->tahun."01";
            $sesi_end = $staf->tahun."04";

        } 
        if($staf->sesi == 2){
            $sesi_start = $staf->tahun."05";
            $sesi_end = $staf->tahun."08";

        }
        else{
            $sesi_start = $staf->tahun."09";
            $sesi_end = $staf->tahun."12";

        }

        $data = ViewPayroll::find()
                    ->select(['*'])
                   ->where(['between', 'CAST(MPH_PAY_MONTH AS INT)', $sesi_start, $sesi_end])
                   ->andWhere(['LIKE', 'MPDH_INCOME_CODE', 'B1000', false])
                   ->andWhere(['!=', 'MPH_TOTAL_DEDUCTION', 0])
                   ->andWhere(['!=', 'MPH_TOTAL_ALLOWANCE', 0])
               //    ->andWhere('(MPH_TOTAL_DEDUCTION/MPH_TOTAL_ALLOWANCE*100) > 60')
                   ->andWhere('( (MPH_TOTAL_ALLOWANCE - MPH_TOTAL_DEDUCTION) / MPH_TOTAL_ALLOWANCE * 100) < 40')
                   ->andWhere(['sm_ic_no' => $id])
                   ->orderBy(['MPH_PAY_MONTH'=>SORT_ASC])
                   ->all();

        return $this->render('detail-view-kj', [
                    'data' => $data, 'staf' => $staf, 'model' => $model
        ]);
    }
    
       public function SenaraiRekod(string $start, string $end) {
          
           
           $name = Yii::$app->request->get('ICNO');
           
        
          if($name == '' || $name == null){
              
              $data = new ActiveDataProvider([
              'query' => ViewPayroll::find()
                    ->select([
                       'sm_ic_no',
                        'COUNT(*) as cnt'
                       ])

                   ->where(['between', 'CAST(MPH_PAY_MONTH AS INT)', $start, $end])
                   ->andWhere(['LIKE', 'MPDH_INCOME_CODE', 'B1000', false])
                   ->andWhere(['!=', 'MPH_TOTAL_DEDUCTION', 0])
                   ->andWhere(['!=', 'MPH_TOTAL_ALLOWANCE', 0])
                   ->andWhere('( (MPH_TOTAL_ALLOWANCE - MPH_TOTAL_DEDUCTION) / MPH_TOTAL_ALLOWANCE * 100) < 40')
                   ->having(['>=', 'COUNT(MPH_PAY_MONTH)', 4])
                   ->orderBy(['sm_ic_no'=>SORT_ASC])
                   ->groupBy(['sm_ic_no']),
            
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
              
          }else{
              
              $data = new ActiveDataProvider([
            'query' => ViewPayroll::find()
                    ->select([
                       'sm_ic_no',
                        'COUNT(*) as cnt'
                       ])

                  ->with('kakitangan')
                   ->where(['between', 'CAST(MPH_PAY_MONTH AS INT)', $start, $end])
                   ->andWhere(['LIKE', 'MPDH_INCOME_CODE', 'B1000', false])
                   ->andWhere(['>', 'MPH_TOTAL_DEDUCTION', 0])
                   ->andWhere(['>', 'MPH_TOTAL_ALLOWANCE', 0])
                 //  ->andWhere('(MPH_TOTAL_DEDUCTION/MPH_TOTAL_ALLOWANCE*100) > 60')
                   ->andWhere('( (MPH_TOTAL_ALLOWANCE - MPH_TOTAL_DEDUCTION) / MPH_TOTAL_ALLOWANCE * 100) < 40')
                   ->andWhere(['=', 'sm_ic_no', $name])
                   ->having(['>=', 'COUNT(MPH_PAY_MONTH)', 4])
                   ->orderBy(['sm_ic_no'=>SORT_ASC])
                   ->groupBy(['sm_ic_no']),
            
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
              
          }
        
        
        return $data;
    }
    
       public function actionLaporanAdmin() {
           
           $request = Yii::$app->request;
        
           if($request->get('tahun')){

                $sesi = $request->get('sesi');
                $tahun = $request->get('tahun');

                if($sesi == 1){
                    $sesi_start = $tahun."01";
                    $sesi_end = $tahun."04";

                }
                if($sesi == 2){
                    $sesi_start = $tahun."05";
                    $sesi_end = $tahun."08";

                }
                if($sesi == 3){
                    $sesi_start = $tahun."09";
                    $sesi_end = $tahun."12";

                }
                
           

            }else{
                $tahun = "2015";
                $sesi_start = $tahun."01";
                $sesi_end = $tahun."06";
           }
       
           
      
            $permohonan = $this->SenaraiRekod($sesi_start, $sesi_end);
            $search = new Tblprcobiodata();

            return $this->render('laporan-admin', [
                         'permohonan' => $permohonan,
                        'search' => $search,
            ]);
        }
        
        
        //example 
        
        public function actionHantarNoti(){
                   
       $request = \Yii::$app->request;
            $sesi = $request->get('sesi');
            $tahun = $request->get('tahun');
            
            if(!is_null($sesi) && !is_null($tahun)){
                
                $sesi = $request->get('sesi');
                $tahun = $request->get('tahun');

                if($sesi == 1){
                    $sesi_start = $tahun."01";
                    $sesi_end = $tahun."04";

                }    
                if($sesi == 2){
                    $sesi_start = $tahun."05";
                    $sesi_end = $tahun."08";

                }
                else{
                    $sesi_start = $tahun."09";
                    $sesi_end = $tahun."12";

                }

            
               $senaraiPayroll =  ViewPayroll::find()
                    ->select([
                       'sm_ic_no',
                        'COUNT(*) as cnt'
                       ])
                   ->with('staff')
                   ->where(['between', 'CAST(MPH_PAY_MONTH AS INT)', $sesi_start, $sesi_end])
                   ->andWhere(['LIKE', 'MPDH_INCOME_CODE', 'B1000', false])
                   ->andWhere(['>', 'MPH_TOTAL_DEDUCTION', 0])
                   ->andWhere(['>', 'MPH_TOTAL_ALLOWANCE', 0])
                  // ->andWhere('(MPH_TOTAL_DEDUCTION/MPH_TOTAL_ALLOWANCE*100) > 60')
                   ->andWhere('( (MPH_TOTAL_ALLOWANCE - MPH_TOTAL_DEDUCTION) / MPH_TOTAL_ALLOWANCE * 100) < 40')
                   ->having(['>=', 'COUNT(MPH_PAY_MONTH)', 4])
                   ->orderBy(['sm_ic_no'=>SORT_ASC])
                   ->groupBy(['sm_ic_no'])->all();
               
               
             
                $error = false;
                foreach ($senaraiPayroll as $payroll){
                 $senarai = TblRekod::find()->where(['icno' => $payroll->sm_ic_no])->exists() ; 
                 $rekod  = TblRekod::find()->where(['icno' => $payroll->sm_ic_no, 'status_maklumbalas' => 1])->exists() ;   
                 if(!$senarai || $rekod){
                    
                  $setPegawai = SetPegawai::find()->where(['pemohon_icno' => $payroll->sm_ic_no])->one();
                  $rekod = new TblRekod();
                  $rekod->icno = $payroll->sm_ic_no;
                  $rekod->sesi = $request->get('sesi');
                  $rekod->tahun = $request->get('tahun');
                  $rekod->tarikh_noti = date('Y-m-d H:i:s');
                  $rekod->kp = $setPegawai->peraku_icno;
                  $rekod->kj = $setPegawai->pelulus_icno;
                  $rekod->save();
                   
                  $noty = $this->notification('Keterhutangan Kewangan Serius', "Permohonan Penjelasan Bagi Perincian Potongan Emolumen Kurang 40%
                  Daripada Emolumen Bulanan Berdasarkan Penyata Gaji Bulanan.", $payroll->sm_ic_no); 
    
                  }
               
                  $noty = $this->notification('Keterhutangan Kewangan Serius', "Pemakluman kakitangan Di Jabatan Tuan Mempunyai Emolumen Kurang 40% Daripada Emolumen Bulanan.", $payroll->staff->pelulus_icno); 

                   if(!$noty){
                       $error = true;
                   }

                }
                
                
             
                if($error){
                     Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Notifikasi Tidak Berjaya Dihantar']);
                }else{
                    
                     Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Notifikasi Berjaya Dihantar']);

                }

               }else{
                   Yii::$app->session->setFlash('alert', ['title' => 'Parameter Salah!', 'type' => 'error', 'msg' => 'Notifikasi Tidak Berjaya Dihantar']);

               }
               
              return $this->redirect(['laporan-admin', 'sesi' => $request->get('sesi'), 'tahun' => $request->get('tahun'),  'senarai' => $senarai, 'rekod' => $rekod]);
            
        }
        
       public function actionHalamanKj() {
        $permohonan = $this->GridSenaraiKj();
        return $this->render('halaman-kj', [
                    'permohonan' => $permohonan,
        ]);
    }
    
      public function GridSenaraiKj() { 
         $icno = Yii::$app->user->getId();
         $data = new ActiveDataProvider([
            'query' => TblRekod::find()->where(['kj' => $icno]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $data;
    }
        
    
            public function actionNotifyKakitangan(){
                   
            $request = \Yii::$app->request;
            $sesi = $request->get('sesi');
            $tahun = $request->get('tahun');
            
            if(!is_null($sesi) && !is_null($tahun)){
                
                $sesi = $request->get('sesi');
                $tahun = $request->get('tahun');

                if($sesi == 1){
                    $sesi_start = $tahun."01";
                    $sesi_end = $tahun."04";

                }
                  if($sesi == 2){
                    $sesi_start = $tahun."05";
                    $sesi_end = $tahun."08";

                }
                else{
                    $sesi_start = $tahun."09";
                    $sesi_end = $tahun."12";

                }

            
               $senaraiPayroll =  ViewPayroll::find()
                    ->select([
                       'sm_ic_no',
                        'COUNT(*) as cnt'
                       ])
                   ->with('staff')
                   ->where(['between', 'CAST(MPH_PAY_MONTH AS INT)', $sesi_start, $sesi_end])
                   ->andWhere(['LIKE', 'MPDH_INCOME_CODE', 'B1000', false])
                   ->andWhere(['>', 'MPH_TOTAL_DEDUCTION', 0])
                   ->andWhere(['>', 'MPH_TOTAL_ALLOWANCE', 0])
                   ->andWhere('( (MPH_TOTAL_ALLOWANCE - MPH_TOTAL_DEDUCTION) / MPH_TOTAL_ALLOWANCE * 100) < 40')
                   ->having(['>=', 'COUNT(MPH_PAY_MONTH)', 4])
                   ->orderBy(['sm_ic_no'=>SORT_ASC])
                   ->groupBy(['sm_ic_no'])->all();
               
               
             
                $error = false;
                foreach ($senaraiPayroll as $payroll){
                 $rekod  = TblRekod::find()->where(['icno' => $payroll->sm_ic_no, 'status_maklumbalas' => null])->exists() ; 
                 
                 if($rekod){
                 $this->notification('Keterhutangan Kewangan Serius', "Permohonan Penjelasan Bagi Perincian Potongan Emolumen Kurang 40%
                  Daripada Emolumen Bulanan Berdasarkan Penyata Gaji Bulanan.", $payroll->sm_ic_no); 
    
                  }
                }
                
                if($error){
                     Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Notifikasi Tidak Berjaya Dihantar']);
                }else{
                    
                     Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Notifikasi Berjaya Dihantar']);

                }

               }else{
                   Yii::$app->session->setFlash('alert', ['title' => 'Parameter Salah!', 'type' => 'error', 'msg' => 'Notifikasi Tidak Berjaya Dihantar']);

               }
               
              return $this->redirect(['laporan-admin', 'sesi' => $request->get('sesi'), 'tahun' => $request->get('tahun'), 'rekod' => $rekod]);
            
        }
    
        
        public function actionCarianAdmin() {
        $permohonan = $this->SenaraiRekodKakitangan();
        $search = new \app\models\hronline\Tblprcobiodata();

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['carian-permohonan-admin', 'ICNO' => $search->ICNO]);  
        }

        return $this->render('carian-admin', [
                     'permohonan' => $permohonan,
                    'search' => $search,
        ]);
    }
    
   
    
        public function SenaraiRekodKakitangan() {
        $data = new ActiveDataProvider([
            'query' => TblRekod::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $data;
    }
    
         public function actionCarianPermohonanAdmin($ICNO) {
         $permohonan = $this->GridCarianPermohonanAdmin($ICNO);
         $search = new \app\models\hronline\Tblprcobiodata();

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['carian-permohonan-admin', 'ICNO' => $search->ICNO]);
            
        }

        return $this->render('carian-admin', [
                    'permohonan' => $permohonan,
                    'search' => $search,
                    'ICNO' => $ICNO,
        ]);
    }
    
    
     public function GridCarianPermohonanAdmin($icno) {
        $data = new ActiveDataProvider([
            'query' => TblRekod::find()->where(['icno' => $icno]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }
}
