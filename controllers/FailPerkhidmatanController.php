<?php

namespace app\controllers;
use yii\filters\AccessControl;
use Yii;
use app\models\hronline\tblrscofileno;
use app\models\hronline\tblrscofilenoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
use app\models\brp\Tblrscobrp;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Tblpengalamankerja;
use app\models\hronline\Tblkeluarga;
use app\models\hronline\Tblrscopsnstatus;
use app\models\hronline\Tblretireage;
use app\models\hronline\Tblpendidikan;
use app\models\vhrms\ViewPayroll;

/**
 * FailPerkhidmatanController implements the CRUD actions for tblrscofileno model.
 */
class FailPerkhidmatanController extends Controller
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
                     'delete' => ['POST'],
                ],
            ],
        ];
    }


    /**
     * Lists all tblrscofileno models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new tblrscofilenoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single tblrscofileno model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    
//     public function actionView($icno) {
//     $maklumat = Tblrscobrp::find()->where(['icno'=> $this->findModelbyic($icno)])->orderBy(['brp_id' => SORT_DESC])->all();
//     $maklumat2 = Tblrscobrp::find()->where(['icno'=> $this->findModelbyic($icno)])->limit(1)->all();
//       
//     $nama = Tblprcobiodata::find()->where(['ICNO' => $icno])->all();
//     $waris =Tblkeluarga::find()->where(['ICNO' => $icno])->all();
//         
//         return $this->render('view', ['alamat' => $this->findModelbyicno($icno), 'ICNO' => $icno,
//            'maklumat2' => $maklumat2,  'maklumat' => $maklumat, 'nama' => $nama, 'waris'=> $waris
//            ]);
//    }
//    
//        public function actionViewuser($icno) {
//          $maklumat = Tblrscobrp::find()->where(['icno'=> $icno])->orderBy(['brp_id' => SORT_DESC])->all();
//          $maklumat2 = Tblrscobrp::find()->where(['icno'=> $icno])->limit(1)->all();
//       
//          $nama = Tblprcobiodata::find()->where(['ICNO' => $icno])->all();
//          $waris =Tblkeluarga::find()->where(['ICNO' => $icno])->all();
//          
//          return $this->render('viewuser', ['alamat' => $this->findModelbyicno($icno), 'ICNO' => $icno,
//            
//            
//         'maklumat' => $maklumat, 'maklumat2' => $maklumat2, 'nama'=> $nama, 'waris'=> $waris
//                
//                ]);
//    }
    
       public function actionView($icno) {
      $alamat = \app\models\hronline\Tblrscofileno::find()->where(['ICNO' => $icno])->orderBy(['id' => SORT_DESC])->all();
        return $this->render('view', ['alamat' => $alamat, 'ICNO' => $icno]);
    }
    
     public function actionViewuser($icno) {
         $alamat = \app\models\hronline\Tblrscofileno::find()->where(['ICNO' => $icno])->orderBy(['id' => SORT_DESC])->all();
        return $this->render('viewuser', ['alamat' => $alamat, 'ICNO' => $icno]);
    }

    /**
     * Creates a new tblrscofileno model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    
      public function actionBukuRekod($icno) {
         $maklumat = Tblrscobrp::find()->where(['icno'=> $icno])->orderBy(['brp_id' => SORT_DESC])->all();
         $maklumat2 = Tblrscobrp::find()->where(['icno'=> $icno])->limit(1)->all();
       
         $nama = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
         $waris = Tblkeluarga::find()->where(['ICNO' => $icno])->all();
         $pengalaman = Tblpengalamankerja::find()->where(['ICNO' => $icno])->all();
         $sijil = Tblpendidikan::find()->where(['ICNO' => $icno])->all();
          
         $pencen = Tblrscopsnstatus::find()->where(['ICNO' => $icno])->orderBy(['id' => SORT_DESC])->one();
         $bersara = Tblretireage::find()->where(['ICNO' => $icno])->one();
        
        return $this->render('buku-rekod', ['alamat' => $this->findModelbyicno($icno), 'ICNO' => $icno,
            
            
         'maklumat' => $maklumat, 'maklumat2' => $maklumat2, 'nama'=> $nama,'waris' => $waris,
         'pengalaman' => $pengalaman  , 'sijil' => $sijil, 'pencen' => $pencen, 'bersara' => $bersara
      
         ]);
    }
    
    public function actionTugasGenerateLetter()
    { 
         $css = file_get_contents('./css/brp.css');
         $icno = Yii::$app->user->getId();
         $maklumat = Tblrscobrp::find()->where(['icno' => $icno])->orderBy(['brp_id' => SORT_DESC])->all();//cari semua mesyuarat
         $nama = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
       
         $content = $this->renderPartial('_contoh', [ 'maklumat'=> $maklumat, 'nama'=> $nama]);
        
        
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
            'options' => ['title' => 'Nota Serah Tugas'],
            // call mPDF methods on the fly
               'marginTop' => 35,
         
            'methods' => [
              'SetHeader' => ['Buku Rekod Perkhidmatan'],
                'WriteHTML' => [$css, 1]
             
            ]
        ]);
      
        // return the pdf output as per the destination setting
        return $pdf->render();
    }
    
    
    public function actionCreate()
    {
        $model = new tblrscofileno();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing tblrscofileno model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    
     public function actionTambahFail($icno) {
     //   $request = Yii::$app->request;
       // $id = $request->get('id');
        $model = new Tblrscofileno();
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';
        
        if ($model->load(Yii::$app->request->post())) {
            $model->ICNO = $icno;
//            $Tblrscofileno = $request->post()['Tblrscofileno'];
//            $COFileNo  = $Tblrscofileno['COFileNo'];
//          
//            $COFileNoEftvDt = date_format(date_create($request->post('COFileNoEftvDt')), 'Y-m-d');
//            $model->COFileNoEftvDt  = $COFileNoEftvDt;
//            $model->COFileNo = $COFileNo;
            $model->save(false);
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
               
            return $this->redirect(['view', 'icno' => $model->ICNO]);
        } 
   
        return $this->render('tambah-fail', [
                    'model' => $model,'lla'=>$lla, 'icno' => $icno, 'nd' => $nd, 'lnd' => $lnd

        ]);
    }
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
    /**
     * Deletes an existing tblrscofileno model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $model = $this->findModelbyid($id);
        $model->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dipadam']);
        return $this->redirect(['view', 'icno' => $model->ICNO]);
    }

    /**
     * Finds the tblrscofileno model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return tblrscofileno the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    
     protected function findModelbyid($id) {
        if (($model = Tblrscofileno::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
       protected function findModelbyicno($icno) {
        if (($model = Tblrscofileno::findAll(['ICNO' => $icno])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findModelbyic($icno) {
        if (($model = Tblrscobrp::findAll(['icno' => $icno])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
