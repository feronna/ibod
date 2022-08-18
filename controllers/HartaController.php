<?php
namespace app\controllers;
use app\models\hronline\Tblkeluarga;
use app\models\hronline\Tblprcobiodata;
use app\models\vhrms\ViewPayroll;
use app\models\harta\TblElaun;
use app\models\harta\TblBayaran;
use yii\helpers\ArrayHelper;
use app\models\harta\TblTambahHarta;
use app\models\harta\TblHarta;
use yii\helpers\Json;
use app\models\harta\TblSenarai;
use app\models\cuti\SetPegawai;
use app\models\harta\TblKeteranganHarta;
use app\models\harta\TblAdmin;
use yii\data\ActiveDataProvider;
use app\models\harta\TblAhliMesyuarat;
use app\models\Notification;
use app\models\harta\TblMesyuarat;
use app\models\harta\TblHartaSearch;
use yii\helpers\Html;
use kartik\mpdf\Pdf;
use app\models\harta\TblElaunPasangan;
use app\models\harta\TblPemotonganPasangan;
use yii\filters\AccessControl;
use Yii;
use yii\filters\VerbFilter;
use app\models\harta\TblPendapatanPasangan;

use yii\db\Expression;
use app\models\hronline\Department;
error_reporting(0);


class HartaController extends \yii\web\Controller
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
  
    public function actionIndex()
    {
        return $this->render('index');
    }
     public function actionJenisHarta()
    {
        return $this->render('jenis-harta');
    }
    
     public function actionMainKemaskini()
    {
        return $this->render('main-kemaskini');
    }

    public function actionPermohonan()
    {
        return $this->render('permohonan');
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

    
    
     public function actionMaklumatPegawai()
    {
        $icno = Yii::$app->user->getId();
        $maklumat = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $pasangan =  Tblkeluarga::find()->where(['ICNO' => $icno, 'RelCd' => [02,01]])->all();
        $models = TblHarta::find()->where(['icno'=> $icno, 'status' => [4,5]])->exists();
        
        return $this->render('maklumat-pegawai', ['maklumat'=>$maklumat,'pasangan' => $pasangan, 'models' => $models]);
    }
    
      public function actionPadamBayaran($id) {
        $icno = Yii::$app->user->getId(); 
        $padamBayaran = TblBayaran::find()->where(['id' => $id, 'icno' => $icno])->one();
        $padamBayaran->delete();
        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Rekod Berjaya Dipadam']);
        return $this->redirect(['jumlah-pinjaman', 'id' => $padamBayaran->id]);
    }
    
       public function actionPadamBayaranPasangan($id) {
        $padamBayaran = TblPemotonganPasangan::find()->where(['id' => $id])->one();
        $padamBayaran->delete();
        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Rekod Berjaya Dipadam']);
        return $this->redirect(['jumlah-pinjaman', 'id' => $padamBayaran->id]);
    }
      public function actionPadamElaun($id) {
        $icno = Yii::$app->user->getId(); 
        $padamElaun = TblElaun::find()->where(['id' => $id, 'icno' => $icno])->one();
        $padamElaun->delete();
        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Rekod Berjaya Dipadam']);
        return $this->redirect(['jumlah-pendapatan', 'id' => $padamElaun->id]);
    }
    
      public function actionPadamElaunPasangan($id) {
        $padamElaunPasangan = TblElaunPasangan::find()->where(['id' => $id])->one();
        $padamElaunPasangan->delete();
        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Rekod Berjaya Dipadam']);
        return $this->redirect(['jumlah-pendapatan', 'id' => $padamElaunPasangan->id]);
    }
    
    public function actionPadamTambahHarta($id) {
        $padamTambahHarta = TblTambahHarta::find()->where(['id' => $id])->one();
        $padamTambahHarta ->delete();
        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Rekod Berjaya Dipadam']);
        return $this->redirect(['pertambahan', 'id' => $padamTambahHarta ->id]);
    }
    
    public function actionPadamTambahHarta2($id) {
        $padamTambahHarta = TblTambahHarta::find()->where(['id' => $id])->one();
        $padamTambahHarta ->delete();
        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Rekod Berjaya Dipadam']);
        return $this->redirect(['pengkemaskinian', 'id' => $padamTambahHarta->id]);
    }
  
        public function actionTindakans($id){
        $request = Yii::$app->request;
        $modell= TblHarta::find()->where(['id'=> $id])->one(); 
        $icno = $modell->kakitangan->ICNO;
        $model = TblHarta::find()->where(['id' => $id, 'icno' => $icno])->one();
        $aset = TblTambahHarta::find()->where(['harta_id'=> $id])->all();
        
          if ($model->load(Yii::$app->request->post())) {
           
            $TblHarta = $request->post()['TblHarta'];
            $status_pelulus = $TblHarta['status_pelulus'];
            $ulasan_pelulus = $TblHarta['ulasan_pelulus'];
            $model->status_pelulus = $status_pelulus;
            $model->ulasan_pelulus = $ulasan_pelulus;
            $model->ADEdrsdDt = date('Y-m-d H:i:s');
            $model->save(false);
            
             foreach ($aset as $aset){
                $aset->ADEdrsdDt = $model->ADEdrsdDt;
                $aset->save(false);
             }
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan']);
           return $this->redirect(['data-mesyuarat']);
        }
        return $this->render('tindakans', ['model' => $model, 'aset' => $aset]);
    }
    
      public function actionJumlahPendapatan() {
      $icno = Yii::$app->user->getId();
      $self = Tblprcobiodata::findOne(['ICNO'=> $icno]);
      $MPH_STAFF_ID = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->Pengguna()])->one();
 
      $pasangan =  Tblkeluarga::find()->where(['ICNO' => $icno, 'RelCd' => [02,01]])->one();
      $pasangankedua =  Tblkeluarga::find()->where(['ICNO' => $icno, 'RelCd' => [01,02]])->orderBy(['id' => SORT_DESC])->one(); 
      $elaun = TblElaun::find()->where(['icno' => $icno])->all();
      $elaunPasangan = TblElaunPasangan::find()->where(['icno' => $pasangan->FamilyId])->all();
      $elaunPasanganKedua = TblElaunPasangan::find()->where(['icno' => $pasangankedua->FamilyId])->all();
      $jumElaun = TblElaun::find()->where(['icno' => $icno])->with('pend')->limit(1)->all();
      $jumElaunPasangan = TblElaunPasangan::find()->where(['icno' => $pasangan->FamilyId])->with('pend')->limit(1)->all();
      $jumElaunPasanganKedua = TblElaunPasangan::find()->where(['icno' => $pasangankedua->FamilyId])->with('pend')->limit(1)->all();

      $a  = Tblprcobiodata::find()->where(['ICNO' => $pasangan->FamilyId])->one();

      $MPH_STAFF_ID_PASANGAN  = ViewPayroll::find()->where(['MPH_STAFF_ID' =>   $this->pasanganPengguna()])->one();
      $MPH_STAFF_ID_PASANGAN_JUMLAH  = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->pasanganPengguna()])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->one();
      $pendapatanPasangan = TblPendapatanPasangan::find()->where(['icno' => $pasangan->FamilyId])->orderBy(['id' => SORT_DESC])->with('el')->with('el2')->limit(1)->all();
      $pendapatanPasanganKedua = TblPendapatanPasangan::find()->where(['icno' => $pasangankedua->FamilyId])->orderBy(['id' => SORT_DESC])->with('el')->with('el2')->limit(1)->all();
      $pendapatanPasangan2 = TblPendapatanPasangan::find()->where(['icno' => $pasangan->FamilyId])->orderBy(['id' => SORT_DESC])->with('el')->one();
      $models = TblHarta::find()->where(['icno'=> $icno, 'status' => [4,5]])->exists();
      $gaji = $this->gaji();
      $gajiPokok = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID,'MPH_PAY_MONTH'=>$gaji,'MPDH_INCOME_CODE' => 'B1000'])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
      $gajiPokokPasangan = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID_PASANGAN,'MPH_PAY_MONTH'=>$gaji,'MPDH_INCOME_CODE' => 'B1000'])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
     
        if(ViewPayroll::find()->where(['MPH_STAFF_ID' => $gajiPokok])->exists() || ViewPayroll::find()->where(['MPH_STAFF_ID_PASANGAN' => $gajiPokokPasangan])->exists()){
            $display='';   
       
        }
        else{  
           $display = 'none';
            
        }
      $model2 = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID,'MPH_PAY_MONTH'=>$gaji])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
      $model2Pasangan = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID_PASANGAN,'MPH_PAY_MONTH'=>$gaji])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
      $b = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID,'MPH_PAY_MONTH'=>$gaji])->andFilterWhere(['or', ['like', 'MPDH_INCOME_CODE','E'], ['like', 'MPDH_INCOME_CODE','B', ['like', 'MPDH_INCOME_CODE','F']]])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->all();
      $bPasangan = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID_PASANGAN,'MPH_PAY_MONTH'=>$gaji])->andFilterWhere(['or', ['like', 'MPDH_INCOME_CODE','E'], ['like', 'MPDH_INCOME_CODE','B']])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->all();
      $pend = TblPendapatanPasangan::find()->where(['icno' => $pasangan->FamilyId])->one();
      $pendKedua = TblPendapatanPasangan::find()->where(['icno' => $pasangankedua->FamilyId])->one();
      $mod =  ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID_PASANGAN])->exists() ; 
        $displaymohon='none';
        $displaymohon2 ='none';
        if ($mod){
            $displaymohon='';  
            $displaymohon2 ='none'; 
        }
        elseif(!$mod){
             $displaymohon='none';
              $displaymohon2 =''; 
        }

      return $this->render('jumlah-pendapatan',compact('model2', 'model2Pasangan', 'elmPasangan', 'elm',
              'epw', 'epwPasangan', 'itp', 'itpPasangan', 'biw', 'biwPasangan', 'itk', 'itkPasangan', 'itka', 'itkaPasangan',
              'a','models', 'gajiPokok','gajiPokokPasangan', 'elaun', 'jumElaun', 'model1', 'self', 'elaunPasangan',
              'jumElaunPasangan', 'pend', 'contohPasangan', 'contoh','pendapatanPasangan2',  'pendapatanPasangan', 'pasangan', 'jumElaunPasangan2', 'MPH_STAFF_ID_PASANGAN_JUMLAH', 'tambah', 'tambahPasangan', 'b', 'bPasangan',
              'mod' , 'displaymohon','displaymohon2', 'model2', 'pasangankedua', 'pasangans', 'pendapatanPasanganKedua', 'pendKedua', 'elaunPasanganKedua','jumElaunPasanganKedua', 'MPH_STAFF_ID'));
      
    }
    
        public function actionTambahElaun() {
        $icno = Yii::$app->user->getId();
      //  $request = Yii::$app->request;
        $model = new TblElaun();  
        
       if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->icno = $icno;
//            $TblElaun = $request->post()['TblElaun'];
//            $pendapatan = $TblElaun['pendapatan'];
//            $jumlah = $TblElaun['jumlah'];
//            $model->pendapatan = $pendapatan;
//            $model->jumlah = $jumlah;
            $model->save();
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
           return $this->redirect(['jumlah-pendapatan', 'icno' => $model->icno]);
        } 
           return $this->render('tambah-elaun', [
                   'model' => $model,'icno' => $icno
       
            ]);
    }
    
       public function actionTambahPendapatanPasangan() {
       $icno = Yii::$app->user->getId();
       $request = Yii::$app->request;
       $pasangan =  Tblkeluarga::find()->where(['ICNO' => $icno, 'RelCd' => [02,01]])->one();
       $pend = new TblPendapatanPasangan();  
       
        if ($pend->load(Yii::$app->request->post()) && $pend->save()) {
            $pend->icno = $pasangan->FamilyId;
            $TblPendapatanPasangan = $request->post()['TblPendapatanPasangan'];
            $gaji_pokok = $TblPendapatanPasangan['gaji_pokok'];
            $itk = $TblPendapatanPasangan['itk'];
            $itka = $TblPendapatanPasangan['itka'];
            $biw = $TblPendapatanPasangan['biw'];
            $itp = $TblPendapatanPasangan['itp'];
            $epw = $TblPendapatanPasangan['epw'];
            $pend->gaji_pokok = $gaji_pokok;
            $pend->itk = $itk;
            $pend->itka = $itka;
            $pend->biw = $biw;
            $pend->itp = $itp;
            $pend->epw = $epw;
            $pend->jumlah = $pend->gaji_pokok + $pend->itk + $pend->itka + $pend->biw + $pend->itp + $pend->epw;
            $pend->save();
          
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
            return $this->redirect(['jumlah-pendapatan', 'icno' => $pend->icno]);
        } 
        return $this->render('tambah-pendapatan-pasangan',['pend' => $pend, 'pasangan' => $pasangan]);
    }
    
    public function actionTambahPendapatanPasanganKedua() {
       $icno = Yii::$app->user->getId();
      // $request = Yii::$app->request;
       $pasangan =  Tblkeluarga::find()->where(['ICNO' => $icno, 'RelCd' => [01]])->orderBy(['id' => SORT_DESC])->one();
       $pend = new TblPendapatanPasangan();  
       
           if ($pend->load(Yii::$app->request->post()) && $pend->save()) {
            $pend->icno = $pasangan->FamilyId;
//            $TblPendapatanPasangan = $request->post()['TblPendapatanPasangan'];
//            $gaji_pokok = $TblPendapatanPasangan['gaji_pokok'];
//            $itk = $TblPendapatanPasangan['itk'];
//            $itka = $TblPendapatanPasangan['itka'];
//            $biw = $TblPendapatanPasangan['biw'];
//            $itp = $TblPendapatanPasangan['itp'];
//            $epw = $TblPendapatanPasangan['epw'];
//            $pend->gaji_pokok = $gaji_pokok;
//            $pend->itk = $itk;
//            $pend->itka = $itka;
//            $pend->biw = $biw;
//            $pend->itp = $itp;
//            $pend->epw = $epw;
            $pend->jumlah = $pend->gaji_pokok + $pend->itk + $pend->itka + $pend->biw + $pend->itp + $pend->epw;
            $pend->save();
          
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
            return $this->redirect(['jumlah-pendapatan', 'icno' => $pend->icno]);
        } 
        return $this->render('tambah-pendapatan-pasangan-kedua',['pend' => $pend, 'pasangan' => $pasangan]);
    }
    
       public function actionTambahPemotonganPasangan() {
       $icno = Yii::$app->user->getId();
//       $request = Yii::$app->request;
       $pasangan =  Tblkeluarga::find()->where(['ICNO' => $icno, 'RelCd' => [02,01]])->one();
       $model = new TblPemotonganPasangan();  
       $jenisBayaran=  ArrayHelper::map(\app\models\harta\RefJenisBayaran::find()->all(), 'id', 'fullname');
       
           if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->icno = $pasangan->FamilyId;
//            $TblPemotonganPasangan = $request->post()['TblPemotonganPasangan'];
//            $jenis_bayaran = $TblPemotonganPasangan['jenis_bayaran'];
//            $jumlah = $TblPemotonganPasangan['jumlah'];
//            $model->jenis_bayaran = $jenis_bayaran;
//            $model->jumlah = $jumlah;
            $model->save();
          
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
            return $this->redirect(['jumlah-pinjaman', 'icno' => $model->icno]);
        } 
        return $this->render('tambah-pemotongan-pasangan',['model' => $model, 'pasangan' => $pasangan, 'jenisBayaran' => $jenisBayaran]);
    }
    
       public function actionTambahPemotonganPasanganKedua() {
       $icno = Yii::$app->user->getId();
//       $request = Yii::$app->request;
       $pasangan =  Tblkeluarga::find()->where(['ICNO' => $icno, 'RelCd' => [02,01]])->orderBy(['id' => SORT_DESC])->one();
       $model = new TblPemotonganPasangan();  
       $jenisBayaran=  ArrayHelper::map(\app\models\harta\RefJenisBayaran::find()->all(), 'id', 'fullname');
       
          if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->icno = $pasangan->FamilyId;
//            $TblPemotonganPasangan = $request->post()['TblPemotonganPasangan'];
//            $jenis_bayaran = $TblPemotonganPasangan['jenis_bayaran'];
//            $jumlah = $TblPemotonganPasangan['jumlah'];
//            $model->jenis_bayaran = $jenis_bayaran;
//            $model->jumlah = $jumlah;
            $model->save();
          
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
            return $this->redirect(['jumlah-pinjaman', 'icno' => $model->icno]);
        } 
        return $this->render('tambah-pemotongan-pasangan-kedua',['model' => $model, 'pasangan' => $pasangan, 'jenisBayaran' => $jenisBayaran]);
    }
    
    
     public function actionTambahElaunPasangan() {
        $icno = Yii::$app->user->getId();
        $pasangan =  Tblkeluarga::find()->where(['ICNO' => $icno, 'RelCd' => [02,01]])->one();
   //     $request = Yii::$app->request;
        $model = new TblElaunPasangan();
        
         if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->icno = $pasangan->FamilyId;
//            $TblElaunPasangan = $request->post()['TblElaunPasangan'];
//            $pendapatan = $TblElaunPasangan['pendapatan'];
//            $jumlah = $TblElaunPasangan['jumlah'];
//            $model->pendapatan = $pendapatan;
//            $model->jumlah = $jumlah;
            $model->save();
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
           return $this->redirect(['jumlah-pendapatan', 'icno' => $model->icno]);
        } 
           return $this->render('tambah-elaun-pasangan', [
                   'model' => $model,'icno' => $icno
       
            ]);
    }
    
      public function actionTambahElaunPasanganKedua() {
        $icno = Yii::$app->user->getId();
        $pasangan =  Tblkeluarga::find()->where(['ICNO' => $icno, 'RelCd' => [01]])->orderBy(['id' => SORT_DESC])->one();
       // $request = Yii::$app->request;
        $model = new TblElaunPasangan();  
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->icno = $pasangan->FamilyId;
//            $TblElaunPasangan = $request->post()['TblElaunPasangan'];
//            $pendapatan = $TblElaunPasangan['pendapatan'];
//            $jumlah = $TblElaunPasangan['jumlah'];
//            $model->pendapatan = $pendapatan;
//            $model->jumlah = $jumlah;
            $model->save();
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
           return $this->redirect(['jumlah-pendapatan', 'icno' => $model->icno]);
        } 
           return $this->render('tambah-elaun-pasangan-kedua', [
                   'model' => $model,'icno' => $icno
       
            ]);
    }
    
        public function actionKemaskiniElaun($id) {
     //   $request = Yii::$app->request;
        $model = $this->findModelbyid($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            $TblElaun = $request->post()['TblElaun'];
//            $pendapatan = $TblElaun['pendapatan'];
//            $jumlah = $TblElaun['jumlah'];
//            $model->pendapatan = $pendapatan;
//            $model->jumlah = $jumlah;
//            $model->save();
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);
           return $this->redirect(['jumlah-pendapatan', 'icno' => $model->icno]);
        }
        return $this->render('kemaskini-elaun', [
                    'model' => $model]);
    }
    
        public function actionKemaskiniElaunPasangan($id) {
 //       $request = Yii::$app->request;
        $model = TblElaunPasangan::find()->where(['id' => $id])->one();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            $TblElaunPasangan = $request->post()['TblElaunPasangan'];
//            $pendapatan = $TblElaunPasangan['pendapatan'];
//            $jumlah = $TblElaunPasangan['jumlah'];
//            $model->pendapatan = $pendapatan;
//            $model->jumlah = $jumlah;
//            $model->save();
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);
           return $this->redirect(['jumlah-pendapatan']);
        }
        return $this->render('kemaskini-elaun-pasangan', [
                    'model' => $model]);
    }
    public function actionJumlahPinjaman() {
     
      $icno = Yii::$app->user->getId();
      $self = Tblprcobiodata::findOne(['ICNO'=>$icno]);
 
      $MPH_STAFF_ID = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->Pengguna()])->one();
      
      $a  = Tblprcobiodata::find()->where(['ICNO' => $self->kakitangans->ICNO])->one();
      $MPH_STAFF_ID_PASANGAN  = ViewPayroll::find()->where(['MPH_STAFF_ID' =>$this->pasanganPengguna()])->one();
      
      
      $pasangan =  Tblkeluarga::find()->where(['ICNO' => $icno, 'RelCd' => [02,01]])->one();
      $pasangankedua =  Tblkeluarga::find()->where(['ICNO' => $icno, 'RelCd' => [01,02]])->orderBy(['id' => SORT_DESC])->one(); 
    

      $bayaran = TblBayaran::find()->where(['icno' => $icno])->all();
      $jumBayaran = TblBayaran::find()->where(['icno' => $icno])->limit(1)->all();
      $models = TblHarta::find()->where(['icno'=> $icno, 'status' => [4,5]])->exists();
      $potong = TblPemotonganPasangan::find()->where(['icno' => $pasangan->FamilyId])->all();
      $potongKedua = TblPemotonganPasangan::find()->where(['icno' => $pasangankedua->FamilyId])->all();
      $potong2 = TblPemotonganPasangan::find()->where(['icno' => $pasangan->FamilyId])->with('el')->with('el2')->with('el3')->one();
      $potong2Kedua = TblPemotonganPasangan::find()->where(['icno' => $pasangankedua->FamilyId])->with('el')->with('el2')->with('el3')->one();
      $jumElaunPasangan = TblPemotonganPasangan::find()->where(['icno' => $pasangan])->limit(1)->all();
      $jumElaunPasanganKedua = TblPemotonganPasangan::find()->where(['icno' => $pasangankedua])->limit(1)->all();
      $gaji = $this->gaji();
      $pinjaman = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID,'MPH_PAY_MONTH'=>$gaji])->andFilterWhere(['or', ['like', 'MPDH_INCOME_CODE','P'], ['like', 'MPDH_INCOME_CODE','D'], ['like', 'MPDH_INCOME_CODE','Z']])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->all();
      $pinjamanPasangan = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID_PASANGAN,'MPH_PAY_MONTH'=>$gaji])->andFilterWhere(['or', ['like', 'MPDH_INCOME_CODE','P'], ['like', 'MPDH_INCOME_CODE','D'],['like', 'MPDH_INCOME_CODE','Z']])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->all();
      $pinjamanPasangan2 = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID_PASANGAN,'MPH_PAY_MONTH'=>$gaji])->andFilterWhere(['or', ['like', 'MPDH_INCOME_CODE','P'], ['like', 'MPDH_INCOME_CODE','D']])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
      $bPasangan = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID_PASANGAN,'MPH_PAY_MONTH'=>$gaji])->andFilterWhere(['or', ['like', 'MPDH_INCOME_CODE','P'], ['like', 'MPDH_INCOME_CODE','D'], ['like', 'MPDH_INCOME_CODE','Z']])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->all();
     // $bPasanganKedua = ViewPayroll::find()->where(['sm_ic_no' => $MPH_STAFF_ID_PASANGAN2,'MPH_PAY_MONTH'=>$gaji])->andFilterWhere(['or', ['like', 'MPDH_INCOME_CODE','P'], ['like', 'MPDH_INCOME_CODE','D'], ['like', 'MPDH_INCOME_CODE','Z']])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->all();
         $mod =  ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID_PASANGAN])->exists() ; 
        $displaymohon='none';
        $displaymohon2 ='none';
        if ($mod){
            $displaymohon='';  
            $displaymohon2 ='none'; 
        }
        elseif(!$mod){
             $displaymohon='none';
              $displaymohon2 =''; 
        }
       if(ViewPayroll::find()->where(['MPH_STAFF_ID' => $pinjaman])->exists() || ViewPayroll::find()->where(['MPH_STAFF_ID_PASANGAN' => $pinjamanPasangan2])->exists()){
            $display='';   
       
        }
        else{  
           $display = 'none';
            
        }
      $pendapatanPasangan2 = TblPendapatanPasangan::find()->where(['icno' => $pasangan->FamilyId])->orderBy(['id' => SORT_DESC])->with('el')->limit(1)->one();
      $jumlahPinjaman = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID,'MPH_PAY_MONTH'=>$gaji])->andFilterWhere(['or', ['like', 'MPDH_INCOME_CODE','P'], ['like', 'MPDH_INCOME_CODE','D'], ['like', 'MPDH_INCOME_CODE','F']])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
      $jumlahPinjamanPasangan = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID_PASANGAN,'MPH_PAY_MONTH'=>$gaji])->andFilterWhere(['or', ['like', 'MPDH_INCOME_CODE','P'], ['like', 'MPDH_INCOME_CODE','D', ['like', 'MPDH_INCOME_CODE','Z']]])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
      $MPH_STAFF_ID_PASANGAN_JUMLAH  = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->pasanganPengguna()])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->one();
      return $this->render('jumlah-pinjaman', compact('pinjaman', 'self', 'MPH_STAFF_ID', 'model1', 'jumlahPinjaman',
              'bayaran', 'jumBayaran', 'models', 'a', 'pasangan', 'potong', 'potong2', 'pinjamanPasangan', 'MPH_STAFF_ID_PASANGAN','mod','displaymohon','displaymohon2',
              'jumlahPinjamanPasangan','MPH_STAFF_ID_PASANGAN_JUMLAH', 'bPasangan','jumElaunPasangan', 'pinjamanPasangan2','pendapatanPasangan2', 'pasangankedua','potongKedua', 'potong2Kedua', 'jumElaunPasanganKedua'));
      
      
      
    }
    
     public function actionTambahBayaran() {
        $icno = Yii::$app->user->getId();
      //  $request = Yii::$app->request;
        $model = new TblBayaran();             
        $jenisBayaran=  ArrayHelper::map(\app\models\harta\RefJenisBayaran::find()->all(), 'id', 'fullname');
      
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->icno = $icno;
//            $TblBayaran = $request->post()['TblBayaran'];
//            $bayaran = $TblBayaran['bayaran'];
//            $jumlah = $TblBayaran['jumlah'];
//            $model->bayaran = $bayaran;
//            $model->jumlah = $jumlah;
            $model->save();
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
           return $this->redirect(['jumlah-pinjaman', 'icno' => $model->icno]);
        } 
           return $this->render('tambah-bayaran', [
                   'model' => $model,'icno' => $icno, 'jenisBayaran'=> $jenisBayaran
       
            ]);
    }
    
      public function actionKemaskiniBayaran($id) {
  //      $request = Yii::$app->request;
        $model = $this->findModelbyidBayaran($id);
        $jenisBayaran=  ArrayHelper::map(\app\models\harta\RefJenisBayaran::find()->all(), 'id', 'fullname');
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            $TblBayaran = $request->post()['TblBayaran'];
//            $bayaran = $TblBayaran['bayaran'];
//            $jumlah = $TblBayaran['jumlah'];
//            $model->bayaran = $bayaran;
//            $model->jumlah = $jumlah;
//            $model->save();
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);
           return $this->redirect(['jumlah-pinjaman', 'icno' => $model->icno]);
        }
        return $this->render('kemaskini-bayaran', [
                    'model' => $model, 'jenisBayaran'=> $jenisBayaran]);

    }
    
       public function actionKemaskiniBayaranPasangan($id) {
       // $request = Yii::$app->request;
        $model = TblPemotonganPasangan::find()->where(['id'=> $id])->one();
        $jenisBayaran=  ArrayHelper::map(\app\models\harta\RefJenisBayaran::find()->all(), 'id', 'fullname');
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            $TblPemotonganPasangan = $request->post()['TblPemotonganPasangan'];
//            $bayaran = $TblPemotonganPasangan['jenis_bayaran'];
//            $jumlah = $TblPemotonganPasangan['jumlah'];
//            $model->jenis_bayaran = $bayaran;
//            $model->jumlah = $jumlah;
//            $model->save();
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);
           return $this->redirect(['jumlah-pinjaman']);
        }
        return $this->render('kemaskini-bayaran-pasangan', [
                    'model' => $model, 'jenisBayaran'=> $jenisBayaran]);

    }
    
       public function actionPertambahan()
    {
        $icno =Yii::$app->user->getId();
        $dataProvider1 = TblHarta::find()->where(['icno' => Yii::$app->user->getId(), 'status'=> null])->max('id');
        $model = TblTambahHarta::find()->andWhere(['icno' => Yii::$app->user->getId(), 'harta_id' => $dataProvider1])->all();
         $models = TblHarta::find()->where(['icno'=> $icno, 'status' => [4,5]])->exists();
        return $this->render('pertambahan', [
          
            'model' => $model,'models' => $models
          
        ]);
    }
    
      public function actionPengkemaskinian(){
        $dataProvider1 = TblHarta::find()->where(['icno' => Yii::$app->user->getId(), 'status'=> null])->max('id');
        $model = TblTambahHarta::find()->andWhere(['icno' => Yii::$app->user->getId(), 'harta_id' => $dataProvider1])->all();
        $models = TblHarta::find()->where(['icno'=>  Yii::$app->user->getId(), 'status' => [4,5]])->exists();
        return $this->render('pengkemaskinian', [
          'models' => $models,
            'model' => $model,
          
        ]);
    }
    
     public function actionPelupusan()
    {
        $a = TblTambahHarta::find()->where(['icno' => Yii::$app->user->getId()])->one();
        if ($a->ADEdrsdDt != null){
        $model = TblTambahHarta::find()->andWhere(['icno' => Yii::$app->user->getId()])->all();
        }else{
            echo '';
        }
        
        
        return $this->render('pelupusan', [
            'model' => $model, 'a' => $a
          
        ]);
    }
    
     public function actionTambahHarta() {
        $icno = Yii::$app->user->getId();
        $checkApplication = TblHarta::find()->where(['status' => [1,2,3],'icno' => $icno]);
        if($checkApplication->exists()){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
            return $this->redirect(['harta/semakan']);
        }
        $model = new TblTambahHarta();
        $biodata = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
       
         $peg = \app\models\hronline\Department::find()->where(['id' => $biodata->DeptId])->one();
        if ($model->load(Yii::$app->request->post())) {
            
                            if(TblHarta::find()->where(['icno' => $icno, 'status' => null])->exists()){
                            $tugas1=TblHarta::find()->where(['icno' =>$icno])->max('id');
                            $tugas= TblHarta::find()->where(['id' => $tugas1])->one();
                            }
                            else{
                            $tugas = new TblHarta();
                            $tugas->icno = $icno;
                            $tugas->AssetOwnerNm= $biodata->CONm;
                            $tugas->jawatan = $biodata->jawatan->nama;
                            $tugas->jenis_permohonan = 1;
                            $tugas->gred = $biodata->jawatan->gred;
                            $tugas->jfpiu = $biodata->department->fullname;
                            $tugas->status_lantikan = $biodata->statusLantikan->ApmtStatusNm;
                            $tugas->tarikh_sandangan = $biodata->displayStartDateSandangan;
                            $tugas->tarikh_lantikan = $biodata->mulaLantikan->tarikhMulalantikan;
                            $tugas->ketua_jabatan = $peg->chief;
                            $tugas->kategori = $biodata->jawatan->job_group;
                            $tugas->jawatan_id = $biodata->jawatan->id;
                            $tugas->DeptId = $biodata->DeptId;
                            $tugas->updated_at = date('Y-m-d H:i:s');
                            $tugas->save(false);  
                            }
                            $model->harta_id = $tugas->id;
                            $model->icno = $icno;
                            $model->save(false);
           
             Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Telah Disimpan']);  
   
            return $this->redirect(['pertambahan', 'id' => $model->id]);
        }
     return $this->render('tambah-harta', ['model' => $model, 'biodata' => $biodata]);
    }
    
    
    public function actionTambahHarta2() {
        $icno = Yii::$app->user->getId();
        $checkApplication = TblHarta::find()->where(['status' => [1,2,3],'icno' => $icno]);
        if($checkApplication->exists()){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
            return $this->redirect(['harta/semakan']);
        }
        $model = new TblTambahHarta();
        $biodata = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $peg = \app\models\hronline\Department::find()->where(['id' => $biodata->DeptId])->one();
        
        if ($model->load(Yii::$app->request->post())) {
            
                            if(TblHarta::find()->where(['icno' => $icno, 'status' => null])->exists()){
                            $tugas1=TblHarta::find()->where(['icno' =>$icno])->max('id');
                            $tugas= TblHarta::find()->where(['id' => $tugas1])->one();
                            }
                            else{
                            $tugas = new TblHarta();
                            $tugas->icno = $icno;
                            $tugas->AssetOwnerNm= $biodata->CONm;
                            $tugas->jawatan = $biodata->jawatan->nama;
                            $tugas->jenis_permohonan = 2;
                            $tugas->gred = $biodata->jawatan->gred;
                            $tugas->jfpiu = $biodata->department->fullname;
                            $tugas->status_lantikan = $biodata->statusLantikan->ApmtStatusNm;
                            $tugas->tarikh_sandangan = $biodata->displayStartDateSandangan;
                            $tugas->tarikh_lantikan = $biodata->mulaLantikan->tarikhMulalantikan;
                            $tugas->ketua_jabatan = $peg->chief;
                            $tugas->kategori = $biodata->jawatan->job_group;
                            $tugas->jawatan_id = $biodata->jawatan->id;
                            $tugas->DeptId = $biodata->DeptId;
                            $tugas->updated_at = date('Y-m-d H:i:s');
                            $tugas->save(false);  
                            }
                            $model->harta_id = $tugas->id;
                            $model->icno = $icno;
                            $model->save(false);
            
             Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Telah Disimpan']);  
   
            return $this->redirect(['pengkemaskinian', 'id' => $model->id]);
        }
     return $this->render('tambah-harta2', ['model' => $model, 'biodata' => $biodata]);
    }
    
      public function actionKemaskiniHarta($id) {
            $model = $this->findModelbyidHarta($id);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->save(false);
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);
           return $this->redirect(['pertambahan']);
        }
        return $this->render('kemaskini-harta', [
                    'model' => $model]);

    }
    
       public function actionKemaskiniHarta2($id) {
       $model = $this->findModelbyidHarta($id);
      if ($model->load(Yii::$app->request->post()) && $model->save()) {
        $model->save(false);
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);
           return $this->redirect(['pengkemaskinian', 'icno' => $model->icno]);
        }
        return $this->render('kemaskini-harta2', [
                    'model' => $model]);

    }

       public function actionPadamHarta($id){
        $icno = Yii::$app->user->getId();
        $request = Yii::$app->request;
        $biodata = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
       $peg = \app\models\hronline\Department::find()->where(['id' => $biodata->DeptId])->one();
        $model = $this->findModelbyidHarta($id);
        $checkApplication = TblHarta::find()->where(['status' => [1,2,3],'icno' => $icno]);
        if($checkApplication->exists()){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
            return $this->redirect(['harta/pelupusan']);
        }
          if($model->load($request->post())){
              
                if(TblHarta::find()->where(['icno' => $icno, 'status' => null])->exists()){
                            $tugas1=TblHarta::find()->where(['icno' =>$icno])->max('id');
                            $tugas= TblHarta::find()->where(['id' => $tugas1])->one();
                            }
                            else{
                            $tugas = new TblHarta();
                            $tugas->icno = $icno;
                            $tugas->AssetOwnerNm = $biodata->CONm;
                            $tugas->jawatan = $biodata->jawatan->nama;
                            $tugas->jenis_permohonan = 3;
                            $tugas->gred = $biodata->jawatan->gred;
                            $tugas->jfpiu = $biodata->department->fullname;
                            $tugas->status_lantikan = $biodata->statusLantikan->ApmtStatusNm;
                            $tugas->tarikh_sandangan = $biodata->displayStartDateSandangan;
                            $tugas->tarikh_lantikan = $biodata->mulaLantikan->tarikhMulalantikan;
                            $tugas->ketua_jabatan = $peg->chief;
                            $tugas->kategori = $biodata->jawatan->job_group;
                            $tugas->jawatan_id = $biodata->jawatan->id;
                            $tugas->DeptId = $biodata->DeptId;
                            $tugas->updated_at = date('Y-m-d H:i:s');
                            $tugas->save(false);  
                            }
                            
            $model->status_padam =  $request->post()['TblTambahHarta']['status_padam'];
            $model->lupus_id = $tugas->id;
            $model->save(false);

            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Rekod Berjaya Disimpan']);
            return $this->redirect(['harta/pelupusan']);
        }
                return $this->render('padam-harta', [
                    'model' => $model]);
            }
        
    
        public function actionPengakuanPegawai(){
           $icno = Yii::$app->user->getId();
           $maklumat = TblHarta::find()->where(['icno' => $icno,  'jenis_permohonan'=> '2'])->orWhere(['status'=> 1, 'jenis_permohonan'=> '2','icno'=> $icno])->orderBy(['id' => SORT_DESC])->limit(1)->all();
           $models = TblHarta::find()->where(['icno'=> $icno])->exists();
           return $this->render('pengakuan-pegawai', ['maklumat'=>$maklumat, 'models' => $models]);
    }
    
     public function actionPengakuanPegawai2(){
           $icno = Yii::$app->user->getId();
           $maklumat = TblHarta::find()->where(['icno' => $icno, 'status'=> null,'jenis_permohonan'=> '3'])->orWhere(['status'=> 1, 'jenis_permohonan'=> '3', 'icno'=> $icno])->orderBy(['id' => SORT_DESC])->limit(1)->all();
           $models = TblHarta::find()->where(['icno'=> $icno])->exists();
           return $this->render('pengakuan-pegawai2', ['maklumat'=>$maklumat, 'models' => $models]);
    }
    
     public function actionPengakuanPegawai3(){
           $icno = Yii::$app->user->getId();
           $perakuList = TblHarta::find()->where(['icno' => $icno])->orderBy(['id' => SORT_DESC])->limit(1)->all();
           $mod = TblHarta::find()->where(['icno' => $perakuList])->exists() ;
           $displaymohon='none';
           if($perakuList->status == null){
           if ($mod){
           $displaymohon='';                          
            }
           elseif(!$mod){
           $displaymohon='none';
            }
            
           }else{
               echo 'none';
           }
  
           $mod2 = TblHarta::find()->where(['icno' => $perakuList, 'status' => null])->exists() ;
           $displaymohon2 ='none';
        
           if ($mod2){
           $displaymohon2 = 'none';                          
            }
           elseif(!$mod2){
           $displaymohon2= '';
            }
           
           $maklumat = TblHarta::find()->where(['icno' => $icno, 'status' => 4])->orderBy(['id' => SORT_DESC])->limit(1)->all();
           $maklumat2 = TblHarta::find()->where(['icno' => $icno, 'jenis_permohonan' => 4])->all();
           $models = TblHarta::find()->where(['icno'=> $icno])->exists();
           $a = TblHarta::find()->where(['icno' => $icno, 'status' => 4])->orderBy(['id' => SORT_DESC])->one();
           return $this->render('pengakuan-pegawai3', ['maklumat'=>$maklumat, 'models' => $models, 'maklumat2'=> $maklumat2, 'a' => $a,
               'mod' => $mod, 'displaymohon' => $displaymohon, 'mod2' => $mod2, 'displaymohon2' => $displaymohon2]);
    }
    
       public function actionPengakuanPegawai4(){
           $icno = Yii::$app->user->getId();
           $maklumat = TblHarta::find()->where(['icno' => $icno, 'status' => null])->orWhere(['icno'=> $icno ,'status' => [1,2]])->orderBy(['id' => SORT_DESC])->limit(1)->all();
           $models = TblHarta::find()->where(['icno'=> $icno, 'status' => 4])->exists();
           
           return $this->render('pengakuan-pegawai4', ['maklumat'=>$maklumat, 'models' => $models]);
    }
    
     public function actionSemakan()
    {
        $icno = Yii::$app->user->getId();
        $semakan = TblHarta::find()->where(['icno' => $icno, 'status' => [1,2,3,4,5]])->all();
        return $this->render('semakan', ['semakan' => $semakan]);
    }
    
      public function actionBorang($id)
    {   
        $modell= TblHarta::find()->where(['id'=> $id])->one(); 
        $icno = $modell->kakitangan->ICNO;
        $modelz = TblTambahHarta::find()->where(['icno' => $icno, 'status_padam' =>1])->all();
        $maklumat = TblHarta::find()->where(['icno' => $icno])->one();
        $pasangan =  Tblkeluarga::find()->where(['ICNO' => $icno, 'RelCd' => [02,01]])->all();
        $pasangan2 =  Tblkeluarga::find()->where(['ICNO' => $icno, 'RelCd' => [02,01]])->one();
        $pasangankedua =  Tblkeluarga::find()->where(['ICNO' => $icno, 'RelCd' => [01,02]])->orderBy(['id' => SORT_DESC])->one(); 
         $gaji = $this->gaji();  
        $self = Tblprcobiodata::findOne(['ICNO'=>$icno]);
    
        $MPH_STAFF_ID = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->PenggunaBorang($id)])->one();
       
        $a  = Tblprcobiodata::find()->where(['ICNO' => $self->kakitangans->ICNO])->one();
        $MPH_STAFF_ID_PASANGAN  = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->pasanganPenggunaBorang($id)])->one();
      
      
          $pinjamanPasangan = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->pasanganPenggunaBorang($id)])->andWhere(['MPH_PAY_MONTH' => $this->gaji()])->andFilterWhere(['or', ['like', 'MPDH_INCOME_CODE','P'], ['like', 'MPDH_INCOME_CODE','D'],['like', 'MPDH_INCOME_CODE','Z']])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->all();
       
        
        $elaun = TblElaun::find()->where(['icno' => $icno])->all();
        $elaunPasangan = TblElaunPasangan::find()->where(['icno' => $pasangan2->FamilyId])->all();
        $elaunPasanganKedua = TblElaunPasangan::find()->where(['icno' => $pasangankedua->FamilyId])->all();
        $jumElaunPasangan = TblElaunPasangan::find()->where(['icno' => $pasangan2])->with('pend')->limit(1)->all();
        $jumElaunPasangan2 = TblPemotonganPasangan::find()->where(['icno' => $pasangan2])->limit(1)->all();
        $jumElaunPasanganKedua = TblElaunPasangan::find()->where(['icno' => $pasangankedua])->with('pend')->limit(1)->all();
        $jumElaun = TblElaun::find()->where(['icno' => $icno])->limit(1)->all();
    
        $model = TblTambahHarta::find()->where(['status_padam' => '0', 'icno' => $icno])->all();

       
        $gajiPokok = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID,'MPH_PAY_MONTH'=>$gaji,'MPDH_INCOME_CODE' => 'B1000'])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
        $gajiPokokPasangan = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID_PASANGAN,'MPH_PAY_MONTH'=>$gaji,'MPDH_INCOME_CODE' => 'B1000'])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
     
        if(ViewPayroll::find()->where(['MPH_STAFF_ID' => $gajiPokok])->exists() || ViewPayroll::find()->where(['MPH_STAFF_ID_PASANGAN' => $gajiPokokPasangan])->exists()){
            $display='';   
       
        }
        else{  
           $display = 'none';
            
        }
       $mod2 = TblPemotonganPasangan::find()->where(['icno' => $pasangan2->FamilyId])->exists() ; 
//       $mod = TblPendapatanPasangan::find()->where(['icno' =>  $pasangan2->FamilyId])->exists(); 
//       $displaymohon='none';
//        
//        if ($mod){
//            $displaymohon='';  
//            $displaymohon2 = 'none';    
//        }
//        elseif(!$mod){
//             $displaymohon='none';
//             $displaymohon2 ='';
//        }
       
        $mod =  ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID_PASANGAN])->exists() ; 
        $displaymohon='none';
        $displaymohon2 ='none';
        if ($mod){
            $displaymohon='';  
            $displaymohon2 ='none'; 
        }
        elseif(!$mod){
             $displaymohon='none';
              $displaymohon2 =''; 
        }
        
          if ($mod2){
         
            $displaymohon3 = 'none';    
        }
        elseif(!$mod2){
             
             $displaymohon3 ='';
        }
        $model2 = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID,'MPH_PAY_MONTH'=>$gaji])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
        $model2Pasangan = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID_PASANGAN,'MPH_PAY_MONTH'=>$gaji])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
        $pinjaman = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID,'MPH_PAY_MONTH'=>$gaji])->andFilterWhere(['or', ['like', 'MPDH_INCOME_CODE','P'], ['like', 'MPDH_INCOME_CODE','D'], ['like', 'MPDH_INCOME_CODE','Z']])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->all();
        $jumlahPinjaman = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID,'MPH_PAY_MONTH'=>$gaji])->andFilterWhere(['or', ['like', 'MPDH_INCOME_CODE','P'], ['like', 'MPDH_INCOME_CODE','D']])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
        $bayaran = TblBayaran::find()->where(['icno' => $icno])->all();
        $jumBayaran = TblBayaran::find()->where(['icno' => $icno])->limit(1)->all();
      //  $pinjamanPasangan = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID_PASANGAN,'MPH_PAY_MONTH'=>$gaji])->andFilterWhere(['or', ['like', 'MPDH_INCOME_CODE','P'], ['like', 'MPDH_INCOME_CODE','D']])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->all(); 
    
        $b = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID,'MPH_PAY_MONTH'=>$gaji])->andFilterWhere(['or', ['like', 'MPDH_INCOME_CODE','E'], ['like', 'MPDH_INCOME_CODE','B'], ['like', 'MPDH_INCOME_CODE','F']])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->all();
        
        $bPasangan = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID_PASANGAN,'MPH_PAY_MONTH'=>$gaji])->andFilterWhere(['or', ['like', 'MPDH_INCOME_CODE','E'], ['like', 'MPDH_INCOME_CODE','B'], ['like', 'MPDH_INCOME_CODE','F']])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->all();
       
        $pendapatanPasangan2 = TblPendapatanPasangan::find()->where(['icno' => $pasangan2])->orderBy(['id' => SORT_DESC])->with('el')->limit(1)->one();
        $pendapatanPasangan = TblPendapatanPasangan::find()->where(['icno' => $pasangan2->FamilyId])->orderBy(['id' => SORT_DESC])->with('el')->with('el2')->limit(1)->all();
    //    $pendapatanPasangan = TblPendapatanPasangan::find()->where(['icno' => $pasangan2])->orderBy(['id' => SORT_DESC])->with('el')->with('el2')->limit(1)->all();
        $pendapatanPasanganKedua = TblPendapatanPasangan::find()->where(['icno' => $pasangankedua])->orderBy(['id' => SORT_DESC])->with('el')->with('el2')->limit(1)->all();
        $potong = TblPemotonganPasangan::find()->where(['icno' => $pasangan2->FamilyId])->all();
        $potongKedua = TblPemotonganPasangan::find()->where(['icno' => $pasangankedua->FamilyId])->all();
        $potong2 = TblPemotonganPasangan::find()->where(['icno' => $pasangan2->FamilyId])->with('el')->with('el2')->with('el3')->one();
        $potong2Kedua = TblPemotonganPasangan::find()->where(['icno' => $pasangankedua->FamilyId])->with('el')->with('el2')->with('el3')->one();
        $MPH_STAFF_ID_PASANGAN_JUMLAH  = ViewPayroll::find()->where(['MPH_STAFF_ID' => $this->pasanganPengguna()])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->one();
        $jumElaunPasanganKedua2 = TblPemotonganPasangan::find()->where(['icno' => $pasangankedua])->limit(1)->all();
        $jumlahPinjamanPasangan = ViewPayroll::find()->where(['MPH_STAFF_ID' => $MPH_STAFF_ID_PASANGAN,'MPH_PAY_MONTH'=>$gaji])->andFilterWhere(['or', ['like', 'MPDH_INCOME_CODE','P'], ['like', 'MPDH_INCOME_CODE','D', ['like', 'MPDH_INCOME_CODE','Z']]])->orderBy(['MPH_PAY_MONTH' => SORT_DESC])->limit(1)->all();
        
        
        return $this->render('borang', compact('maklumat','pasangan','gajiPokok','model2','elaun','jumElaun', 'jumlahPinjaman','pinjaman','bayaran','jumBayaran',
           'model','a', 'pendapatanPasangan2','pasangan2','pendapatanPasangan', 'b','bPasangan','gajiPokokPasangan', 'model2Pasangan','MPH_STAFF_ID_PASANGAN_JUMLAH',
          'potong2','mod','displaymohon','displaymohon2','displaymohon3','mod2','jumlahPinjamanPasangan','pinjamanPasangan' ,'MPH_STAFF_ID','potong', 'jumElaunPasangan2', 'jumElaunPasangan' ,'elaunPasangan',
          'pendapatanPasangan', 'modelz' ,'pasangankedua', 'potong2Kedua', 'elaunPasanganKedua', 'pendapatanPasanganKedua', 'jumElaunPasanganKedua', 'potongKedua', 'jumElaunPasanganKedua2','MPH_STAFF_ID_PASANGAN'));
    }
    
        public function actionTindakanKetua(){
        $icno = Yii::$app->user->getId();
        $query= TblHarta::find()->where(['ketua_jabatan' => $icno, 'status' => [1,2,3,4,5]]);
           $provider = new ActiveDataProvider([
           'query' => $query,
           'pagination' => [
           'pageSize' =>  10
           ],
           
       ]);
        return $this->render('tindakan-ketua',['provider' => $provider]);
    }
    
      public function actionSenaraiPermohonan(){
        $icno = Yii::$app->user->getId();
        $model = TblAdmin::find()->where(['icno' => $icno])->one();
       #semua staff gred 45 ada akses
        if(!$model && Yii::$app->user->getIdentity()->gredJawatan != 6  && Yii::$app->user->getIdentity()->gredJawatan != 2  ){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['harta/index']); 
        }   
           $provider =   new ActiveDataProvider([
           'query' => TblHarta::find()->where(['!=', 'status', 0]),
           'pagination' => [
           'pageSize' =>  20
           ],    
       ]);
           
         
        return $this->render('senarai-permohonan',['provider' => $provider]);
    }
    
        public function actionPerakuan($id){
        $request = Yii::$app->request;
        $icno = Yii::$app->user->getId();
        $model = TblAdmin::find()->where(['icno' => $icno])->one();
        $ketuaJabatans = TblHarta::find()->where(['ketua_jabatan' => $icno])->one();
     
        #semua staff gred 45 ada akses
        if(!$model && !$ketuaJabatans ){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['harta/index']);
        }   
        
           $selesai = Tblharta::find()->where(['id' => $id])->one();
         
           if(($selesai->status_kj == '1') || ($selesai->status_kj == '0')){
                Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Selesai Diambil Tindakan']);
                return $this->redirect(['harta/tindakan-ketua']);
             
             }
             
            $ketuaJabatan = TblHarta::find()->where(['id' => $id])->one();
           if ($ketuaJabatan->load(Yii::$app->request->post())) {
            #update harta table after kj buat perakuan
            $ketuaJabatan->tarikh_perakuan = date('Y-m-d H:i:s');
            $ketuaJabatan->ulasan_kj = $request->post()['TblHarta']['ulasan_kj'];
            $ketuaJabatan->status_kj =  $request->post()['TblHarta']['status_kj'];
            $ketuaJabatan->status = 2;
            $ketuaJabatan->save(false);
            $this->notification('Harta', 'Permohonan Telah Diperakukan', $selesai->icno);
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Maklumbalas telah selesai']);
            return $this->redirect(['harta/tindakan-ketua']);
        }
        
            return $this->renderAjax('perakuan', compact('model','ketuaJabatan'));
      
    }
    
    public function actionMohon($id){
        $request = Yii::$app->request;
        $mohon = TblHarta::find()->where(['id'=> $id])->one();
        $selesai = Tblharta::find()->where(['id' => $id])->one();
        $aset = TblTambahHarta::find()->where(['harta_id'=> $id])->all();
           if(($selesai->status == '1') || ($selesai->status == '2')|| ($selesai->status == '4')|| ($selesai->status == '5')){
                Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Borang Selesai Dihantar']);
                return $this->redirect(['harta/pengakuan-pegawai']);
             
             }
           if($mohon->load($request->post())){
             
            $mohon->ADDeclDt = date('Y-m-d H:i:s');
            $mohon->status =  $request->post()['TblHarta']['status'];
            $mohon->save(false);
            
             foreach ($aset as $aset){
                $aset->ADDeclDt = $mohon->ADDeclDt;
                $aset->save(false);
             } 
            $this->notification('Harta', 'Perakuan Perisytiharan Harta' . "$mohon->AssetOwnerNm". '&nbsp'. "Menunggu Tindakan Anda. ".Html::a('Klik Sini', ['harta/tindakan-ketua'], ['class' => 'label label-info']), $mohon->ketua_jabatan);
            $this->notification('Harta', 'Permohonan telah dihantar');
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Borang Berjaya Dihantar']);
            return $this->redirect(['harta/pengakuan-pegawai']);
        }
        
            return $this->renderAjax('mohon', compact('mohon'));
      
    }
    
        public function actionMohon3($id){
        $request = Yii::$app->request;
        $mohon = TblHarta::find()->where(['id'=> $id])->one();
        $biodata = Tblprcobiodata::find()->where(['ICNO' => $mohon->icno])->one();
        $peg = \app\models\hronline\Department::find()->where(['id' => $biodata->DeptId])->one();
        
        $checkApplication = TblHarta::find()->where(['status' => [1,2,3],'icno' => $mohon->icno]);
        if($checkApplication->exists()){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Permohonan telah didaftarkan dan masih dalam proses']);
            return $this->redirect(['harta/semakan']);
        }
        $tugas = new TblHarta();
                 
                 if ($tugas->load(Yii::$app->request->post())) {
                           if(TblHarta::find()->where(['icno' => $mohon->icno, 'status' => null])->exists()){
                            $tugas1=TblHarta::find()->where(['icno' =>$mohon->icno])->max('id');
                            $tugas= TblHarta::find()->where(['id' => $tugas1])->one();
                            }
                           
                            $tugas->icno = $mohon->icno;
                            $tugas->AssetOwnerNm= $biodata->CONm;
                            $tugas->jawatan = $biodata->jawatan->nama;
                            $tugas->jenis_permohonan = 4;
                            $tugas->gred = $biodata->jawatan->gred;
                            $tugas->jfpiu = $biodata->department->fullname;
                            $tugas->status_lantikan = $biodata->statusLantikan->ApmtStatusNm;
                            $tugas->tarikh_sandangan = $biodata->displayStartDateSandangan;
                            $tugas->tarikh_lantikan = $biodata->mulaLantikan->tarikhMulalantikan;
                            $tugas->ketua_jabatan = $peg->chief;
                            $tugas->status  =  $request->post()['TblHarta']['status'];
                            $tugas->ADDeclDt = date('Y-m-d H:i:s');
                            $tugas->kategori = $biodata->jawatan->job_group;
                            $tugas->jawatan_id = $biodata->jawatan->id;
                            $tugas->DeptId = $biodata->DeptId;
                            $tugas->updated_at = date('Y-m-d H:i:s');
                            $tugas->save(false);  
            $this->notification('Harta', 'Perakuan Perisytiharan Harta' . "$mohon->AssetOwnerNm". '&nbsp'. "Menunggu Tindakan Anda. ".Html::a('Klik Sini', ['harta/tindakan-ketua'], ['class' => 'label label-info']), $mohon->ketua_jabatan);
            $this->notification('Harta', 'Permohonan telah dihantar');
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Borang Berjaya Dihantar']);
            return $this->redirect(['harta/pengakuan-pegawai3']);
            
            
                           }
        
            return $this->renderAjax('mohon3', compact('mohon', 'tugas'));
      
    }
    
        public function actionMohon2($id){
        $request = Yii::$app->request;
        $mohon = TblHarta::find()->where(['id'=> $id])->one();
        $selesai = Tblharta::find()->where(['id' => $id])->one();
        $aset = TblTambahHarta::find()->where(['icno'=> Yii::$app->user->getId(), 'status_padam' => 1, 'isytihar_lupus' => null])->all();
           if(($selesai->status == '1') || ($selesai->status == '2')|| ($selesai->status == '4')|| ($selesai->status == '5')){
                Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Borang Selesai Dihantar']);
                return $this->redirect(['harta/pengakuan-pegawai2']);
             
             }
           if($mohon->load($request->post())){
             
            $mohon->ADDeclDt = date('Y-m-d H:i:s');
            $mohon->status =  $request->post()['TblHarta']['status'];
            $mohon->save(false);
            
             foreach ($aset as $aset){
                $aset->isytihar_lupus = $mohon->ADDeclDt;
                $aset->save(false);
             }
            $this->notification('Harta', 'Perakuan Perisytiharan Harta' . "$mohon->AssetOwnerNm". '&nbsp'. "Menunggu Tindakan Anda. ".Html::a('Klik Sini', ['harta/tindakan-ketua'], ['class' => 'label label-info']), $mohon->ketua_jabatan);
            $this->notification('Harta', 'Permohonan telah dihantar');
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Borang Berjaya Dihantar']);
            return $this->redirect(['harta/pengakuan-pegawai2']);
        }
        
            return $this->renderAjax('mohon2', compact('mohon'));
      
    }
      public function actionMohon4($id){
        $request = Yii::$app->request;
        $mohon = TblHarta::find()->where(['id'=> $id])->one();
        $selesai = Tblharta::find()->where(['id' => $id])->one();
        $aset = TblTambahHarta::find()->where(['harta_id'=> $id])->all();
 
           if(($selesai->status == '1') || ($selesai->status == '2')|| ($selesai->status == '4')|| ($selesai->status == '5')){
                Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Borang Selesai Dihantar']);
                return $this->redirect(['harta/pengakuan-pegawai4']);
             
             }
           if($mohon->load($request->post())){
             
            $mohon->ADDeclDt = date('Y-m-d H:i:s');
            $mohon->status =  1;
            $mohon->save(false);
            
            foreach ($aset as $aset){
                $aset->ADDeclDt = $mohon->ADDeclDt;
                $aset->save(false);
             }
             
            $this->notification('Harta', 'Perakuan Perisytiharan Harta' . "$mohon->AssetOwnerNm". '&nbsp'. "Menunggu Tindakan Anda. ".Html::a('Klik Sini', ['harta/tindakan-ketua'], ['class' => 'label label-info']), $mohon->ketua_jabatan);
            $this->notification('Harta', 'Permohonan telah dihantar');
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Borang Berjaya Dihantar']);
            return $this->redirect(['harta/pengakuan-pegawai4']);
        }
        
            return $this->renderAjax('mohon4', compact('mohon'));
      
    }
    
     public function actionTambahAdmin() {
        $icno = Yii::$app->user->getId();
        $model = TblAdmin::findOne(['icno' => $icno]);
         if(!$model){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['harta/index']);
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
                         $this->notification('Perisytiharan Harta', 'Tahniah anda menjadi Admin untuk Sistem Perisytiharan Harta.'.Html::a('Klik Sini', ['harta/admin-index'], ['class' => 'btn btn-primary btn-sm']), $adminbaru->icno);
                         $adminbaru->save(false);
                    }
                    else{
                        Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Tidak Wujud Dalam Sistem!']);
                    
                    }
                    
                    return $this->redirect(['harta/tambah-admin']);
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
            return $this->redirect(['harta/index']);
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
                         $this->notification('Perisytiharan Harta', 'Tahniah Anda menjadi Ahli Mesyuarat untuk Sistem Peristiharan Harta.', $meetingbaru->icno);
                      $meetingbaru->save();
                    }
                    else{
                        Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Tidak Wujud Dalam Sistem!']);
                    
                    }
                    
                    return $this->redirect(['harta/tambah-ahli-mesyuarat']);
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
    
    public function actionPengumuman(){
        $icno = Yii::$app->user->getId();
        $model = TblAdmin::findOne(['icno' => $icno]);
         if(!$model){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['harta/index']);
        }  
         if (Yii::$app->request->post('notifistaf')) {
            $this->notifistaf();
            return $this->refresh();
        }
        
        $request = Yii::$app->request;
        if($request->post()){

            $title = $request->post('title');
            $content = $request->post('content');

            $allBiodata = ArrayHelper::map(Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'ICNO');

            foreach ($allBiodata as $ic){
                $ntf = new Notification();
                $ntf->icno = $ic;
                $ntf->title = $title;
                $ntf->content = $content;
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
            }

            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Notifikasi Berjaya dihantar']);
            return $this->redirect(['harta/pengumuman']);
        }
        return $this->render('pengumuman');
    }
    
        public function actionDataMesyuarat(){
        $icno = Yii::$app->user->getId();
        $model = TblAdmin::findOne(['icno' => $icno]);
        if(!$model){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['harta/index']);
        }
        
      //  $pendaftar = Tblprcobiodata::find()->where(['icno'=> Yii::$app->user->getId(), 'gredJawatan' => 6, 'Status' => 1])->one();

        $urusMesyuarat = TblMesyuarat::find()->orderBy(['id' => SORT_DESC])->limit(1)->all();    
        $searchModel = new TblHartaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
          $models = TblHarta::find()->All();
          if (Yii::$app->request->post('simpan'))  {
            
              foreach ($models as $data) {
                    if('y'.$data->id == Yii::$app->request->post($data->id)){
                    $model = $this->findModelbyidHartas($data->id);
                    $model->status_pelulus = '1';
                    $model->save(false);
                    }
                    elseif('n'.$data->id == Yii::$app->request->post($data->id)){
                    $model = $this->findModelbyidHartas($data->id);
                    $model->status_pelulus = '0';
                    $model->save(false);
                    }
                      Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan']);
                  
                  

              }

           }
            elseif (Yii::$app->request->post('hantar')) {
            $arrayId = Yii::$app->request->post('selection');
            foreach($arrayId as $applicationId) {


                $model = TblHarta::findOne(['id' => $applicationId , 'letter_sent' => 0]);

                if($model){
                    #check make sure has been approved/declined by pelulus
                 //   $status_pelulus = $model->pelulus->agree;
                   
                    if(!is_null($model->status_pelulus)){
               
                        //    $setPegawai = SetPegawai::findOne('pemohon_icno', $model->icno);

                        if($model->status_pelulus == 1){
                   
                    #approve
                            
                    //----------move old data pemohon to table old_position in ptb ---------//
              
                    //----------move old data pemohon to table old_position in ptb ---------//
                    
                            $model->status = 4; 
                         
                            $this->notification('Harta', "Sila semak status permohonan".Html::a('Klik Sini', ['harta/semakan'], ['class' => 'label label-info']), $model->icno);

                        }else{
                            #decline
                             $model->status = 5;
                          
                              $this->notification('Harta', "Sila semak status permohonan.".Html::a('Klik Sini', ['harta/semakan'], ['class' => 'label label-info']), $model->icno);
                        }
                              
                            
                    }
                    $model->ADEdrsdBy = 680622125118;
                    $model->letter_sent = 1; #change sent status to hide from senarai
                    $model->save(false);
                }
                 Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Surat Berjaya dihantar']);
            
                 
                $appICNO = $model->icno;
                
                $port  = TblTambahHarta::find()->where(['icno' => $appICNO, 'harta_id'=> $model->id])->all();
                foreach ($port as $port){
                $port->ADEdrsdBy = 680622125118;
                $removeWhiteSpace = str_replace(' ', '', $model->ADEdrsdRefNo);
                $port->ADEdrsdRefNo= "UMS/ASET/".$removeWhiteSpace."";
                $port->save(false);
             }
                 
          }
      
        }

        return $this->render('data-mesyuarat', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'urusMesyuarat' => $urusMesyuarat, 'port' => $port
         
        ]);
    }
    
       public function actionDataMesyuaratAhli(){
        $icno = Yii::$app->user->getId();
        $model = TblAhliMesyuarat::findOne(['icno' => $icno]);
        if(!$model){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['harta/index']);
        }
        $urusMesyuarat = TblMesyuarat::find()->orderBy(['id' => SORT_DESC])->limit(1)->all();    
        $searchModel = new TblHartaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $models = TblHarta::find()->All();
        return $this->render('data-mesyuarat-ahli', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'urusMesyuarat' => $urusMesyuarat,'models' => $models
        ]);
    }
    
       public function actionGenerateLetter($id)
    {
        $model = TblHarta::findOne(['id' => $id]);
        $letter = TblMesyuarat::findOne(['id' => $id]);
        // get your HTML raw content without any layouts or scripts
       $content = $this->renderPartial('_suratJtkk', ['model' => $model, 'letter' => $letter]);
        
        
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
            'options' => ['title' => 'Isytihar Harta'],
            // call mPDF methods on the fly
           
            'methods' => [
              'SetHeader' => ['Isytihar Harta'],
   
            ]
        ]);
      
        // return the pdf output as per the destination setting
        return $pdf->render();
    }
    
     public function actionUrusMesyuarat() {
            
        $icno = Yii::$app->user->getId();
        $model = TblAdmin::findOne(['icno' => $icno]);
         if(!$model){
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Tiada Akses']);
            return $this->redirect(['harta/index']);
        } 
        $urusMesyuarat = TblMesyuarat::find()->All(); //cari semua mesyuarat
        $urus = new TblMesyuarat(); //untuk mesyuarat baru
        if ($urus->load(Yii::$app->request->post())) {

              $urus->masa_mesyuarat =  Yii::$app->request->post()['masa_mesyuarat'];
             $urus->save(false);
             Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Telah Disimpan']);   
            return $this->redirect(['urus-mesyuarat', 'id' => $urus->id]);
        }
        return $this->render('urus-mesyuarat', ['urus' => $urus, 'urusMesyuarat' => $urusMesyuarat]);
    
    }
 
      public function actionDeleteUrusMesyuarat($id)
    {
        $admin = TblMesyuarat::findOne(['id' => $id]);
        $admin->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dipadam']);
        return $this->redirect(['urus-mesyuarat']);
        
    }
    
      public function actionDetailHarta($id)
    {
       
         $detail = TblTambahHarta::find()->where(['id' => $id ])->one();
         return $this->render('detail-harta', ['detail' => $detail]);
    
        
    }
    
      protected function gaji() {
        $ma  = date('m');
        $ya = date('Y');
       if (($ma == "1") && $ya){
              $y = date('Y',strtotime("-1 year"));
              $m =  date('m',strtotime("-1 months"));
              $pm = $y.$m;   
       }else{
           $y = date('Y');    
           $m =  date('m',strtotime("-1 month"));
           $pm = $y.$m;   
      }

        return $pm;
    }
    

      protected function findModelbyidHartas($id) {
        if (($model = TblHarta::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
        protected function findModelbyid($id) {
        if (($model = TblElaun::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
        protected function findModelbyidBayaran($id) {
        if (($model = TblBayaran::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
      protected function findModelbyidHarta($id) {
        if (($model = TblTambahHarta::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
       protected function findModelbyicno($icno) {
        if (($model = TblElaun::findAll(['icno' => $icno])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
     public function actionStatelist() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $out = TblSenarai::find()->select(['id' => 'senarai_id', 'name' => 'keterangan'])->where(['hartaCd' => $cat_id])->asArray()->all();

                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    public function actionCitylist() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $out = TblKeteranganHarta::find()->select(['id' => 'hartas_id', 'name' => 'keterangan'])->where(['senarai_id' => $cat_id])->asArray()->all();

                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
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
            'query' => Tblprcobiodata::find()->where(['Status' => 1]),
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
    
    
     public function GridCarianPermohonanAdmin($ICNO) {
        $data = new ActiveDataProvider([
            'query' => Tblprcobiodata::find()->where(['ICNO' => $ICNO]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }
    
      protected function Pengguna() {
      $self = Tblprcobiodata::findOne(['ICNO'=> Yii::$app->user->getId()]);
      $model = \app\models\hronline\Umsper::find()->where(['ICNO' => $self->ICNO])->one();
      $models =  ViewPayroll::find()->where(['MPH_STAFF_ID' => $self->COOldID])->one();
      if($self->COOldID == $models->MPH_STAFF_ID){
          $pengguna =  explode(",",$self->COOldID);
      }else{
          $pengguna =  explode(",",$model->COOldID);
      }
      return $pengguna;
    }
    
       protected function pasanganPengguna() {
      $pasangan =  Tblkeluarga::find()->where(['ICNO' => Yii::$app->user->getId(), 'RelCd' => [02,01]])->one();
      $a  = Tblprcobiodata::find()->where(['ICNO' => $pasangan->FamilyId])->one();  
      $model = \app\models\hronline\Umsper::find()->where(['ICNO' => $a->ICNO])->one();
      $models =  ViewPayroll::find()->where(['MPH_STAFF_ID' => $a->COOldID])->one();
      if($a->COOldID == $models->MPH_STAFF_ID){
          $pasanganPengguna =  explode(",",$a->COOldID);
      }else{
          $pasanganPengguna =  explode(",",$model->COOldID);
      }
      return $pasanganPengguna;
    }
    
      protected function PenggunaBorang($id) {
      $modell= TblHarta::find()->where(['id'=> $id])->one(); 
      $model = \app\models\hronline\Umsper::find()->where(['ICNO' => $modell->icno])->one();
      $self = Tblprcobiodata::findOne(['ICNO'=> $modell->icno]);
      $models =  ViewPayroll::find()->where(['MPH_STAFF_ID' => $self->COOldID])->one();
      if($self->COOldID == $models->MPH_STAFF_ID){
          $penggunaBorang =  explode(",",$self->COOldID);
      }else{
          $penggunaBorang =  explode(",",$model->COOldID);
      }
      return $penggunaBorang;
    }
    
     protected function pasanganPenggunaBorang($id) {
      $modell= TblHarta::find()->where(['id'=> $id])->one(); 
      $pasangan =  Tblkeluarga::find()->where(['ICNO' => $modell->icno])->andWhere(['RelCd' => [02,01]])->one();
      $a  = Tblprcobiodata::find()->where(['ICNO' => $pasangan->FamilyId])->one();  
      $model = \app\models\hronline\Umsper::find()->where(['ICNO' => $a->ICNO])->one();
      $models =  ViewPayroll::find()->where(['MPH_STAFF_ID' => $a->COOldID])->one();
      if($a->COOldID == $models->MPH_STAFF_ID){
          $pasanganPenggunaBorang =  explode(",",$a->COOldID);
      }else{
          $pasanganPenggunaBorang =  explode(",",$model->COOldID);
      }
      return $pasanganPenggunaBorang;
    }
    
     
         public function actionListSenarai($icno=null,$jfpiu=null,$status=null) {
        $dataProvider = new ActiveDataProvider([
            'query' => TblHarta::find()
                       ->joinWith('kakitangan')
                       ->joinWith('department')
             
                       ->where(['<>', 'tblprcobiodata.Status', '6']),
              
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);
        
        $dataProvider->query->orderBy([
          //  new \yii\db\Expression("status = 1 ASC"),
            'id' => SORT_ASC,
          //  'icno' => SORT_ASC,
        ]); 
        
        if(isset(Yii::$app->request->queryParams['icno'])){
        $icno? $dataProvider->query->andFilterWhere(['icno' => $icno]):'';}
       
        if(isset(Yii::$app->request->queryParams['jfpiu'])){
        $jfpiu? $dataProvider->query->andFilterWhere(['jfpiu' => $jfpiu]):'';}
        
        if(isset(Yii::$app->request->queryParams['status'])){
        $status? $dataProvider->query->andFilterWhere(['status' => $status]):'';}
   
        return $this->render('list-senarai', [
                'icno' => $icno,
                'jfpiu' => $jfpiu,
                'status' => $status,
                'dataProvider' => $dataProvider,
        ]);
    }
    
    
        public function actionAdminIndex()
    {
        $searchModel = new TblHartaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new TblHarta();
        return $this->render('admin-index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
      public function actionViewPenyelia($DeptId = null, $gredJawatan = null, $ICNO = null, $status_hantar = NULL)
    {
        $icno = Yii::$app->user->getId();
        $penyelia = \app\models\harta\AksesPenyelia::find()->where(['akses_icno' => $icno])->one();
        $dataProvider = new ActiveDataProvider([
            'query' => Tblprcobiodata::find()->where(['Status' => 1])
                     ->andWhere(['DeptId' => $penyelia->penyeliaBiodata->DeptId])
                     ->with('biodataHarta'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        if (isset(Yii::$app->request->queryParams['ICNO'])) {
            $ICNO ? $dataProvider->query->andFilterWhere(['ICNO' => $ICNO]) : '';
        }

        if (isset(Yii::$app->request->queryParams['DeptId'])) {
            $DeptId ? $dataProvider->query->andFilterWhere(['DeptId' => $DeptId]) : '';
        }

        if (isset(Yii::$app->request->queryParams['gredJawatan'])) {
            $gredJawatan ? $dataProvider->query->andFilterWhere(['gredJawatan' => $gredJawatan]) : '';
        }
        
        if (isset(Yii::$app->request->queryParams['status_hantar'])) {
            $gredJawatan ? $dataProvider->query->andFilterWhere(['status_hantar' => $status_hantar]) : '';
        }

        return $this->render('view-penyelia', [
            'DeptId' => $DeptId,
            'gredJawatan' => $gredJawatan,
            'ICNO' => $ICNO,
            'dataProvider' => $dataProvider,
            'status_hantar' => $status_hantar
        ]);
    }
    
    


    public function actionKemaskiniDataPeraku($id, $page = null) {
        $request = Yii::$app->request;
        $model = TblHarta::find()->where(['id' => $id])->one();
        $pegawai = ArrayHelper::map(Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm');

 
        if ($request->post()) {
            $model->ketua_jabatan = $request->post()['TblHarta']['ketua_jabatan'];
            $model->ulasan_kj = null;
            $model->status_kj = null;
            if ($model->save(false)) {
                
                if($model->status == NULL){
                  Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya dikemaskini']);
                  return $this->redirect(['harta/view-penyelia', 'page' => $page]);
                }else{
                $this->notification('Harta', 'Perakuan Perisytiharan Harta' .'&nbsp'. "$model->AssetOwnerNm" . '&nbsp' . "untuk tindakan pihak tuan/puan." . Html::a('Klik Sini', ['harta/tindakan-ketua'], ['class' => 'btn btn-primary btn-sm']), $model->ketua_jabatan);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya dikemaskini']);
                return $this->redirect(['harta/view-penyelia', 'page' => $page]);
                }
            }
        }

        return $this->render('kemaskini-data-peraku', compact('model', 'peraku', 'new', 'pegawai'));
    }

   
    
       public function actionViewAkses($akses_dept = null, $akses_campus = null, $akses_icno = null, $jenis_akses = NULL)
    {
       // $icno = Yii::$app->user->getId();
      //  $penyelia = \app\models\myportfolio\AksesPenyelia::find()->where(['akses_icno' => $icno])->one();
        $dataProvider = new ActiveDataProvider([
            'query' => \app\models\harta\AksesPenyelia::find()
                       ->with('penyeliaBiodata'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        if (isset(Yii::$app->request->queryParams['akses_icno'])) {
            $akses_icno ? $dataProvider->query->andFilterWhere(['akses_icno' => $akses_icno]) : '';
        }

        if (isset(Yii::$app->request->queryParams['akses_dept'])) {
            $akses_dept ? $dataProvider->query->andFilterWhere(['akses_dept' => $akses_dept]) : '';
        }

        if (isset(Yii::$app->request->queryParams['akses_campus'])) {
            $akses_campus ? $dataProvider->query->andFilterWhere(['akses_campus' => $akses_campus]) : '';
        }
        
        if (isset(Yii::$app->request->queryParams['jenis_akses'])) {
            $jenis_akses ? $dataProvider->query->andFilterWhere(['jenis_akses' => $jenis_akses]) : '';
        }

        return $this->render('view-akses', [
            'akses_icno' => $akses_icno,
            'akses_dept' => $akses_dept,
            'akses_campus' => $akses_campus,
            'jenis_akses' => $jenis_akses,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
      public function actionTambahAkses() {
        $adminbaru = new \app\models\harta\AksesPenyelia();//untuk admin baru
        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
        $department =  ArrayHelper::map(\app\models\hronline\Department::find()->where(['isActive' => 1])->all(), 'id', 'fullname');
        $campus =  ArrayHelper::map(\app\models\hronline\Campus::find()->all(), 'campus_id', 'campus_name');
        
        if ($adminbaru->load(Yii::$app->request->post()) && $adminbaru->save()) {
             Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah!']);
             $this->notification('Harta', 'Salam Sejahtera, Anda kini adalah Penyelia Sistem Perisytiharan Harta. Terima Kasih.' .'&nbsp'.Html::a('Klik Sini', ['harta/view-penyelia'], ['class' => 'btn btn-primary btn-sm']), $adminbaru->akses_icno);
            return $this->redirect(['harta/view-akses']);
            
            
         }

        return $this->render('tambah-akses', [
       //     'admin' => $admin,
            'adminbaru' => $adminbaru,
            'allbiodata' => $allbiodata,
            'department' => $department,
            'campus' => $campus
        ]);
    }
     public function actionDeleteAkses($id)
    {
        $admin = \app\models\harta\AksesPenyelia::findOne(['id' => $id]);
        $admin->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dipadam']);
        return $this->redirect(['view-akses']);
        
    }
    

             public  function actionNotifistaf()
    {
             
       $model = ArrayHelper::map(\app\models\harta\AksesPenyelia::find()->where(['jenis_akses' => 2])->all(), 'akses_icno', 'akses_icno');

        foreach ($model as $models) {
        $ntf = new Notification(); //noti untuk kp
        $ntf->icno = $models;
        $ntf->title = 'Harta';
        $ntf->content = 'Salam Sejahtera, Tuan/Puan, anda kini adalah Penyelia Sistem Perisytiharan Harta. Emelkan terus ke hafizah.hassan@ums.edu.my (teknikal sistem)
                        sekiranya berlaku sebarang perubahan atau pertambahan staf sebagai penyelia sistem. Terima Kasih.'
                     .Html::a('<i class="fa fa-arrow-right">Klik Disini</i>', ['harta/view-penyelia'],['class' => 'btn btn-primary btn-sm'],$models->akses_icno);
 
        $ntf->ntf_dt = date('Y-m-d H:i:s');
        $ntf->save(false);
        
       
        }
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA DIHANTAR']);
        return $this->redirect('pengumuman');
    }
    
    
      public function actionViewAdmin($DeptId = null, $gredJawatan = null, $ICNO = null, $status = NULL, $category = null, $khidmat = null)
    {
    
        $listicno = $gredJawatan ? Tblprcobiodata::find()->where(['gredJawatan' => $gredJawatan]) : Tblprcobiodata::find()->where(['<>', 'tblprcobiodata.Status', '6']);
        $list = $category ? $listicno->joinWith('jawatan')->where(['gredJawatan.job_category' => $category]) : $listicno;
        $DeptId ? $listicno->where(['DeptId' => $DeptId]) : $listicno;
        $khidmat ? $listicno->joinWith('jawatan')->where(['gredJawatan.job_group' => $khidmat]) : $listicno;
   

             $dataProvider = new ActiveDataProvider([
            'query' => Tblprcobiodata::find()
                      ->where(['ICNO' => $listicno->select(['ICNO'])])
                      ->with('biodataHarta')
                      ->with('jawatan'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
             
             
//                $searchModel = new \app\models\hronline\TblprcobiodataSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $dataProvider->query->orderBy([           
//          'ICNO' => SORT_ASC,   
       //    ]);
    
             
             
             
             
          $selection=(array)Yii::$app->request->post('selection');  
      
//          if (Yii::$app->request->post('simpan'))  {
//              foreach ($selection as $id ){
//
//                   $aa = TblHarta::findOne(['id' => $id]);
//                   
//      //            if($model){
////                     $model->peringkat = Yii::$app->request->post('t'.$model->permohonanID);
//                      
////                     if('y'.$model->permohonanID == Yii::$app->request->post($model->permohonanID)){
////                    $model->kategori_latihan = '1';
////                    }
////                    elseif('n'.$model->permohonanID == Yii::$app->request->post($model->permohonanID)){
////                    $model->kategori_latihan = '0';
////                    }
//                    
//                //       $model->peringatan = Yii::$app->request->post('t'.$model->id);
//               //        $model->status = 22;
//            //          $model->updated_by = Yii::$app->user->getId();
//                   //    $model->save(false);
//                      
//                   $this->notification('Harta', "Peringatan. ".Html::a('Klik Sini', ['harta/permohonan'], ['class' => 'label label-info']), $aa->icno);
//
//                
////        $ntf = new Notification(); //noti untuk kp
////        $ntf->icno = $models;
////        $ntf->title = 'Harta';
////        $ntf->content = 'Salam Sejahtera, Tuan/Puan, anda kini adalah Penyelia Sistem Perisytiharan Harta. Emelkan terus ke hafizah.hassan@ums.edu.my (teknikal sistem)
////                        sekiranya berlaku sebarang perubahan atau pertambahan staf sebagai penyelia sistem. Terima Kasih.'
////                     .Html::a('<i class="fa fa-arrow-right">Klik Disini</i>', ['harta/view-penyelia'],['class' => 'btn btn-primary btn-sm'],$models->akses_icno);
//// 
////        $ntf->ntf_dt = date('Y-m-d H:i:s');
////        $ntf->save(false);
////        
//        
//   //      $ver = Recommendation::find()->where(['type' => 1, 'agree' => null])->all();
//      //  $app = Recommendation::find()->where(['type' => 2, 'agree' => null])->all();
////        
////        foreach($ver as $ver){
////          $this->notification('PTB', "Permohonan Perpindahan Jabatan menunggu tindakan anda. ".Html::a('Klik Sini', ['ptb/senarai-menunggu-setuju'], ['class' => 'label label-info']), $ver->icno);
////        }
////                      
//                      
//                      
//           //       }
//                      
//              } 
//                    
//               //    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar']);
//    
//           }
             

  
          
        if (isset(Yii::$app->request->queryParams['ICNO'])) {
            $ICNO ? $dataProvider->query->andFilterWhere(['ICNO' => $ICNO]) : '';
        }
        

        if (isset(Yii::$app->request->queryParams['DeptId'])) {
            $DeptId ? $dataProvider->query->andFilterWhere(['DeptId' => $DeptId]) : '';
        }

        if (isset(Yii::$app->request->queryParams['gredJawatan'])) {
            $gredJawatan ? $dataProvider->query->andFilterWhere(['gredJawatan' => $gredJawatan]) : '';
        }
        
        if (isset(Yii::$app->request->queryParams['biodataHarta.status'])) {
            $status ? $dataProvider->query->andFilterWhere(['biodataHarta.status' => $status]) : '';
        }
        
//           if (isset(Yii::$app->request->queryParams['category'])) {
//            $category ? $dataProvider->query->andFilterWhere(['category' => $category]) : '';
//        }
        
//                isset(Yii::$app->request->queryParams['gredJawatan.job_category']) ? $dataProvider->query->andFilterWhere
//               (['like', 'gredJawatan.job_category', Yii::$app->request->queryParams['gredJawatan.job_category']]) : '';
//        

        return $this->render('view-admin', [
            'DeptId' => $DeptId,
            'gredJawatan' => $gredJawatan,
            'ICNO' => $ICNO,
            'dataProvider' => $dataProvider,
            'category' => $category,
            'list' => $list,
            'status' => $status,
            'khidmat' => $khidmat, 'aa' => $aa
        ]);
    }
    
         public function actionDashboard() {
        
        $array = TblHarta::find()->select([new Expression('COUNT(*) as jml'), 'AssetOwnerNm as nama'])->where(['>=', 'ADDeclDt', new Expression('(DATE(NOW()) - INTERVAL (WEEKDAY(DATE(NOW()))) DAY)')])
                ->andWhere(['<=', 'ADDeclDt', new Expression('(DATE(NOW() + INTERVAL (6 - WEEKDAY(NOW())) DAY))')])->andWhere(['!=','status' , NULL])->groupBy(new Expression('CAST(`ADDeclDt` as DATE)'))->asArray()->all();

     //   $query = TblRekod::find()->joinWith('department')->select('`dept_id`,count(`dept_id`) AS `_totalCount`')
        
     //   ->andWhere(['=','`department`.`isActive`','1'])->groupBy(['`dept_id`'])->orderBy(['department.fullname' => SORT_ASC]);
         $query = Department::find()->where([ 'isActive' => '1']);
         $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        return $this->render('dashboard', ['model' => $array, 'dataProvider' => $dataProvider]);
    }

  
}
