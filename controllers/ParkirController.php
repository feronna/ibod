<?php

namespace app\controllers;

use Yii;
use app\models\e_perkhidmatan\Parkir;
use app\models\e_perkhidmatan\ParkirSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\cuti\SetPegawai;
use app\models\hronline\Department;
use yii\data\ActiveDataProvider;
use app\models\e_perkhidmatan\TblEvent;
use app\models\aduan\RptTblAccess;


/**
 * ParkirController implements the CRUD actions for Parkir model.
 */
class ParkirController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Parkir models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ParkirSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Parkir model.
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
     * Creates a new Parkir model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Parkir();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Parkir model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
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

    /**
     * Deletes an existing Parkir model.
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
     * Finds the Parkir model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Parkir the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Parkir::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findModel2($event_id)
    {
        if (($model = TblEvent::findOne($event_id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    
        public function actionHalamanUtama()
    {
        $searchModel = new ParkirSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('halaman-utama', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
        public function actionHalamanUtamaParkir($id)
    {
        $searchModel = new ParkirSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('halaman-utama-parkir', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $this->findModel2($id),
        ]);
    }
    
    // Permohonan Parkir (Pemohon)
    public function actionMohon($id)
    {
        $icno = Yii::$app->user->getId(); 
   
        $model = new Parkir();
        $searchModel = new ParkirSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model->icno = $icno;   
        $model->entry_date = date('Y-m-d H:i:s');
        $model2 = $this->findModel2($id);
       
        // dynamic controller  code

        $modelPeg = RptTblAccess::findOne(['access_type' => 'urusetia', 'level' => '1']);

        if ($model->load(Yii::$app->request->post())){
            
        if (Yii::$app->request->post('simpan')){  
            
//        if($modelPeg->staff_icno != NULL){
//        $model->app_by = $modelPeg->staff_icno;
//        }
        
        $model->app_by = $modelPeg->staff_icno;
        $model->event_id = $model2->event_id;
        $model->isActive = 0;
        $model->status_kj = 'Tunggu Perakuan';
        $model->status ='DRAFT DISIMPAN';
        $model->save(false);
        
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya disimpan.']);
        }
        
        elseif(Yii::$app->request->post('hantar')){
        
        $model->isActive = 1;
        $model->status_kj = 'Tunggu Perakuan';
        $model->status ='DALAM TINDAKAN KETUA JABATAN';
        $model->save(false);
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar.']);
        return $this->redirect(['semakan-permohonan', 'id' => $model->id]);      
        }
        
        }
        
        return $this->render('mohon', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model2' => $this->findModel2($id),
            
        ]);        
    }
    
       public function actionSemakanPermohonan()
    { 
        $this->checkingSejarahPermohonan();

        $permohonan = $this->GridPermohonanAktif();

        return $this->render('semakan_permohonan', [
           'permohonan' => $permohonan,
        ]);
    }
    
        public function GridPermohonanAktif() 
    {
        $icno = Yii::$app->user->getId();
        $data = new ActiveDataProvider([
            'query' => Parkir::find()->where(['icno' => $icno])->andWhere(['isActive' => 1]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }
    
    public function actionSejarahPermohonan() 
    {

        $permohonan = $this->GridPermohonanTidakAktif();

        return $this->render('sejarah_permohonan', [
                    'permohonan' => $permohonan,
        ]);
    }
    
    public function GridPermohonanTidakAktif() 
    {
        $icno = Yii::$app->user->getId();
        $data = new ActiveDataProvider([
            'query' => Parkir::find()->where(['icno' => $icno])->andWhere(['isActive' => 0]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }
    
     public function checkingSejarahPermohonan() 
    {
        $permohonan = $this->findSuratTelahDiHantar();

        foreach ($permohonan as $permohonan) {

            $datetime1 = new DateTime($permohonan->letter_date);
            $datetime2 = new DateTIme('now');
            $interval = $datetime1->diff($datetime2);

            if ($interval->format('%d') >= 7) {
                $permohonan->isActive = 0;
                $permohonan->save(false);
            }
        }
    }
    
        protected function findSuratTelahDiHantar() 
    {
        return Parkir::find()->Where(['letter_sent' => [1,2]])->all();
    }
}
