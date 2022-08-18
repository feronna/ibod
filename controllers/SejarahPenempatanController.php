<?php

namespace app\controllers;
use yii\filters\AccessControl;
use Yii;
use app\models\hronline\tblpenempatan;
use app\models\hronline\tblpenempatanSearch;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\TblprcobiodataSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\hronline\Updatestatus;
use yii\data\ActiveDataProvider;

/**
 * SejarahPenempatanController implements the CRUD actions for tblpenempatan model.
 */
class SejarahPenempatanController extends Controller
{
    /**
     * {@inheritdoc}
     */
      public function behaviors()
    {
        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['*'],
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
            
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['halaman-utama', 'admin-view', 'tambah-rekod-penempatan', 'lihat-rekod-kakitangan', 'lihat-rekod-maklumat-penempatan', 'kemaskini-rekod-penempatan'],
                'rules' => [
                    [
                        'actions' => ['halaman-utama', 'admin-view', 'tambah-rekod-penempatan', 'lihat-rekod-kakitangan', 'lihat-rekod-maklumat-penempatan', 'kemaskini-rekod-penempatan'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $icno=Yii::$app->user->getId();
                            if(\app\models\pengesahan\TblAccessCanselori::find()->where(['icno' => $icno,'access' => 1])->exists()){
                            //if(\app\models\pengesahan\TblAccessPenempatan::find()->where(['icno' => $icno,'access' => 1])->exists()){

                                return true;
                            }else{
                                return false;
                            }
                           
                        }
                    ],
                        [
                        'actions' => ['viewuser','kemaskini','lihatbiodata'],
                        'allow' => true,
                        
                    ],
                  
                ],
            ],
                            
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                     'delete' => ['POST'],
                ],
            ],
        ];
    }
    
//    public function behaviors() {
//        return [
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['POST'],
//                ],
//            ],
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['index','create', 'update', 'view', 'halaman-utama', 'admin-view', 'lihat-rekod-kakitangan', 'lihat-rekod-penempatan', 'kemaskini-rekod', 'kemaskini-rekod-penempatan', 'tambah-rekod-penempatan'],
//                'rules' => [
//                    [
//                        'actions' => ['index', 'tambahalamat', 'view', 'update', 'halaman-utama', 'admin-view', 'lihat-rekod-kakitangan', 'lihat-rekod-penempatan', 'kemaskini-rekod', 'kemaskini-rekod-penempatan', 'tambah-rekod-penempatan'],
//                        'allow' => true,
//                        'matchCallback' => function ($rule, $action) {
//                            $icno = Yii::$app->request->get('icno');
//                            $logicno = Yii::$app->user->getId();
//                            $id = Yii::$app->request->get('id');
//                            $access = Yii::$app->user->identity->accessLevel;
//
//                            return $logicno === $icno || $access === 1;
//                        }
//                    ],
//                    [
//                        'actions' => ['lihatalamat', 'update'],
//                        'allow' => true,
//                        'matchCallback' => function ($rule, $action) {
//                            $logicno = Yii::$app->user->getId();
//                            $id = Yii::$app->request->get('id');
//                            $check = \app\models\hronline\Tblretireage::findAll(['id' => $id, 'ICNO' => $logicno]);
//                            $boleh = false;
//                            if (!empty($check)) {
//                                $boleh = true;
//                            }
//
//                            return $boleh === true;
//                        }
//                    ],
//                ],
//            ],
            
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['halaman-utama', 'admin-view', 'tambah-rekod-penempatan', 'lihat-rekod-kakitangan', 'lihat-rekod-penempatan', 'kemaskini-rekod-penempatan'],
//                'rules' => [
//                    [
//                        'actions' => ['halaman-utama', 'admin-view', 'tambah-rekod-penempatan', 'lihat-rekod-kakitangan', 'lihat-rekod-penempatan', 'kemaskini-rekod-penempatan'],
//                        'allow' => true,
//                        'matchCallback' => function ($rule, $action) {
//                           $access = Yii::$app->user->identity->accessLevel;
//                           $secondaccess = Yii::$app->user->identity->accessSecondLevel;
//                           
//                           switch ($access) {
//                                case '1':
//                                      return true;
//                                    break;
//                                case '2':
//                                    
//                                    $secondaccess = Yii::$app->user->identity->accessSecondLevel;
//                                    if ($secondaccess=='1') {
//                                        return true;
//                           
//                                    }
//                                    
//                                    elseif ($secondaccess=='11') {
//                                        return true;
//                           
//                                    }
//                                    
//                                    return false;
//                                    break;
//
//
//                                default:
//                                    return false;
//                                    break;
//                            }  
//
//                            return false;
//                        }
//                    ],
//                        [
//                        'actions' => ['viewuser','kemaskini','lihatbiodata'],
//                        'allow' => true,
//                        
//                    ],
//                  
//                ],
//            ],
      
                            
//        ];
//  }
  

    /**
     * Lists all tblpenempatan models.
     * @return mixed
     */
    
    public function actionIndex()
    {
        $searchModel = new tblpenempatanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
     public function actionHalamanUtama()
    {
//        $carian = new Tblprcobiodata();
        $carian = new TblprcobiodataSearch();
        $dataProvider = $carian->carian(Yii::$app->request->queryParams); 

        return $this->render('halaman-utama', [
                    'carian' => $carian,
                    'model' => $dataProvider,
        ]);
    }

    /**
     * Displays a single tblpenempatan model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

     public function actionView($icno) {
    $alamat = Tblpenempatan::find()->where(['ICNO' => $icno])->orderBy(['date_start' => SORT_DESC])->all();
        return $this->render('view', ['alamat' => $alamat, 'ICNO' => $icno]);
    }
    
     public function actionLihatRekodMaklumatPenempatan($id)
    {
            $biodata = Tblprcobiodata::findOne([$this->findModelbyid($id)]);
            $alamat = Tblpenempatan::find()->where(['id' => $id])->orderBy(['date_start' => SORT_DESC])->all();
            return $this->render('lihat-rekod-maklumat-penempatan', [
            'alamat' => $alamat,
            'model' => $this->findModelbyid($id),
            'biodata' => $biodata,
        ]);
    }
    
      public function actionViewuser($icno) {
     $alamat = Tblpenempatan::find()->where(['ICNO' => $icno])->orderBy(['date_start' => SORT_DESC])->all();
        return $this->render('viewuser', ['alamat' => $alamat, 'ICNO' => $icno]);
    }
    
    public function actionAdminView($id) {
        $id = $id;
        $model = $this->findModel2($id); 
        
            
        return $this->render('admin-view', [
                    'model' => $model,
        ]);
    }
    
    public function actionLihatRekodKakitangan($ICNO) 
    {
        $ICNO = $ICNO;
        $biodata = Tblprcobiodata::findOne(['ICNO'=>$ICNO]);
//        $model = $this->findModelbyicno($ICNO);
        $model = Tblpenempatan::find()->where(['ICNO' => $ICNO])->orderBy(['date_start' => SORT_DESC])->all();
        return $this->render('lihat-rekod-kakitangan', [
                    'model' => $model, 
                    'biodata' => $biodata,
                    'ICNO' => $ICNO,
        ]);
    }
    
    public function actionSuratPenempatan($id) {

        $css = file_get_contents('./css/surat.css');

        $permohonan = \app\models\hronline\TblPenempatan::find()->where(['id' => $id])->andWhere(['in', 'reason_id', ["1", "2", "3", "5", "6"]])->one();
        $biodata = Tblprcobiodata::find()->where(['ICNO' => $permohonan])->one();  //panggil nama surat penerima tersebut                        
        
        $model = \app\models\hronline\Tblrscoadminpost::find()->where(['ICNO' => $ICNO])->max('adminpos_id'); 
        $confirm = \app\models\hronline\Tblrscoadminpost::find()->where(['ICNO' => $ICNO, 'adminpos_id' => $model])->one()->adminpos_id;
        
//        $content = $this->renderPartial('penempatan_letter', ['permohonan' => $permohonan, 'letter' => $permohonan->letter]);

        if($permohonan->reason_id == 1){
            $content = $this->renderPartial('penempatan_letter', ['approvedDept' => $permohonan->department, 'oldDept' => $permohonan->department, 'permohonan' => $permohonan, 'biodata' => $permohonan->biodata]);
        }
        
        if($permohonan->reason_id == 2){
            $content = $this->renderPartial('kenaikan_letter', ['approvedDept' => $permohonan->department, 'oldDept' => $permohonan->department, 'permohonan' => $permohonan, 'biodata' => $permohonan->biodata]);
        }
        
        if($permohonan->reason_id== 3){
            $content = $this->renderPartial('perpindahan_letter', ['approvedDept' => $permohonan->department, 'oldDept' => $permohonan->department, 'permohonan' => $permohonan, 'biodata' => $permohonan->biodata]);
        }
        
        if($permohonan->reason_id== 5){
            $content = $this->renderPartial('lantikan_letter', ['approvedDept' => $permohonan->department, 'oldDept' => $permohonan->department, 'permohonan' => $permohonan, 'biodata' => $permohonan->biodata]);
        }
        
        if($permohonan->reason_id== 6){
            $content = $this->renderPartial('lain_letter', ['approvedDept' => $permohonan->department, 'oldDept' => $permohonan->department, 'permohonan' => $permohonan, 'biodata' => $permohonan->biodata]);
        }
             
            
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
            'options' => ['title' => ''],
            // call mPDF methods on the fly
            'marginTop' => 35,
            'marginLeft' => 24,
            'marginRight' => 24,
            'methods' => [
                'SetHeader' => [''],
                'SetFooter' => [''],
                'WriteHTML' => [$css, 1]
            ]
        ]);

        return $pdf->render();
    }
    
    public function actionPerubahanData($ICNO) 
    {
        $ICNO = $ICNO;
        $model = $this->findModelbyicno($ICNO);
        
            $usern = $ICNO;
            $query= Updatestatus::find()->where(['usern' => $usern])->andFilterWhere(['like', 'COTableName','tblpenempatan'])->orderBy(['COUpadteDate' => SORT_DESC]);
       
           $provider = new ActiveDataProvider([
           'query' => $query,
           'pagination' => [
           'pageSize' =>  10
           ],
            
       ]);
           
        
        return $this->render('perubahan-data', [
                    'model' => $model, 
                    'ICNO' => $ICNO,
                    'provider' => $provider
        ]);
    }
    
//        public function actionKemaskiniRekod($ICNO) 
//    {
//        $ICNO = $ICNO;
//        $model = $this->findModelbyicno($ICNO);
//        
//        return $this->render('kemaskini-rekod', [
//                    'model' => $model, 
//                    'ICNO' => $ICNO,
//        ]);
//    }

    /**
     * Creates a new tblpenempatan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new tblpenempatan();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
     public function actionTambahRekodPenempatan($ICNO)
    {
        $admin=Yii::$app->user->getId();
        $biodata = Tblprcobiodata::findOne(['ICNO'=>$ICNO]);
        $model = new tblpenempatan();
        $update = new Updatestatus();

//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        }
        
        if ($model->load(Yii::$app->request->post())){
            $model->date_update = date('Y-m-d H:i:s');
            $model->ICNO = $ICNO;
            $model->update_by = $admin;
            $model->save();

            $biodata->DeptId = $model->dept_id;
            $biodata->campus_id = $model->campus_id;
            $biodata->last_update = date('Y-m-d H:i:s');
            $biodata->last_updater = $admin;
            $biodata->save();

            
            $changes = [];
            $tempObj = tblpenempatan::findOne(['ICNO'=>$ICNO]);
            $attrib = $model->activeAttributes();
            for($i=0;$i<count($attrib);$i++){

                if($tempObj->{$attrib[$i]}!=$model->{$attrib[$i]}){
                    array_push($changes,[$attrib[$i],$tempObj->{$attrib[$i]},$model->{$attrib[$i]}]);   
                }
       
            }
//            $update->usern = Yii::$app->user->getId();
            $update->usern = $ICNO;
            $update->COUpdateCompUser = Yii::$app->user->getId();
            $update->COTableName = 'tblpenempatan';
            $update->COActivity = 0;
            $update->COUpadteDate = date('Y-m-d H:i:s');
            $update->COUpdateIP = $this->getRealUserIp();
            $update->COUpdateComp = $this->getRealUserIp();
            $update->COUpdateSQL = serialize($changes);
            $update->idval = $model->id;
            $update->save();
            
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
            
            return $this->redirect(['lihat-rekod-maklumat-penempatan', 'id' => $model->id]);
        }

        return $this->render('tambah-rekod-penempatan', [
            'model' => $model,
            'ICNO' => $ICNO,
            'biodata' => $biodata,
            'admin' => $admin,
        ]);
    }


    /**
     * Updates an existing tblpenempatan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
     public function actionUpdate($id) {
        $model = $this->findModelbyid($id);
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {


            return $this->redirect(['view', 'icno' => $model->ICNO]);
        }
        return $this->render('update', [
                    'model' => $model,'lla'=>$lla, 'nd' => $nd, 'lnd' => $lnd,
        ]);
    }
    
    public function actionKemaskiniRekodPenempatan($id) {
        $biodata = Tblprcobiodata::findOne([$this->findModelbyid($id)]);
        $alamat = Tblpenempatan::find()->where(['id' => $id])->orderBy(['date_start' => SORT_DESC])->all();

        $admin=Yii::$app->user->getId();
        $model = $this->findModelbyid($id);
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';

        if ($model->load(Yii::$app->request->post())){
            $model->date_update = date('Y-m-d H:i:s');
            $model->update_by = $admin;
            $model->save();
            
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);

            return $this->redirect(['lihat-rekod-maklumat-penempatan', 'id' => $model->id]);
        }
        
        return $this->render('kemaskini-rekod-penempatan', [
                    'model' => $model,'lla'=>$lla, 'nd' => $nd, 'lnd' => $lnd,'admin' => $admin,  
                    'biodata' => $biodata, 'alamat' => $alamat
        ]);
    }

    /**
     * Deletes an existing tblpenempatan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $model = $this->findModelbyid($id);
        $model->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dipadam']);
        return $this->redirect(['lihat-rekod-kakitangan', 'ICNO' => $model->ICNO]);
    }

    /**
     * Finds the tblpenempatan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return tblpenempatan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
  
      protected function findModelbyid($id) {
        if (($model = Tblpenempatan::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
       protected function findModelbyicno($icno) {
        if (($model = Tblpenempatan::findAll(['ICNO' => $icno])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
     protected function findModel2($id) {
        if (($model = Tblprcobiodata::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
     function getRealUserIp()
    {
        switch (true) {
            case (!empty($_SERVER['HTTP_X_REAL_IP'])):
                return $_SERVER['HTTP_X_REAL_IP'];
            case (!empty($_SERVER['HTTP_CLIENT_IP'])):
                return $_SERVER['HTTP_CLIENT_IP'];
            case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])):
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            default:
                return $_SERVER['REMOTE_ADDR'];
        }
    }
}
