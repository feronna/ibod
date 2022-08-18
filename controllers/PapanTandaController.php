<?php

namespace app\controllers;

use Yii;
use app\models\e_perkhidmatan\PapanTanda;
use app\models\e_perkhidmatan\PapanTandaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\cuti\SetPegawai;
use app\models\hronline\Department;
use app\models\ln\Pegawai;
use app\models\aduan\RptTblAccess;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use app\models\Notification;
use app\models\e_perkhidmatan\TblEvent;


/**
 * PapanTandaController implements the CRUD actions for PapanTanda model.
 */
class PapanTandaController extends Controller
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
     * Lists all PapanTanda models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PapanTandaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
        public function actionIndex_1()
    {
        $searchModel = new PapanTandaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index_1', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PapanTanda model.
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
     * Creates a new PapanTanda model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PapanTanda();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PapanTanda model.
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
     * Deletes an existing PapanTanda model.
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
     * Finds the PapanTanda model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PapanTanda the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PapanTanda::findOne($id)) !== null) {
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
    
        
    protected function notifikasi($icno, $content)
    {
        //--------Model Notification-----------//
                $ntf = new Notification(); //noti untuk kp
                $ntf->icno = $icno;
                $ntf->title = 'Permohonan Papan Tanda';
                $ntf->content = $content;
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
                //--------Model Notification-----------//
    }
    
    public function actionHalamanUtama()
    {
        $searchModel = new PapanTandaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('halaman-utama', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionHalamanUtamaPapanTanda($id)
    {
        $searchModel = new PapanTandaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('halaman-utama-papan-tanda', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
             'model' => $this->findModel2($id),
        ]);
    }
    
    // Permohonan Papan Tanda (Pemohon)
    public function actionMohon($id)
    {
        $icno = Yii::$app->user->getId(); 
   
        $model = new PapanTanda();
        $searchModel = new PapanTandaSearch();
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
        $model->masa =  Yii::$app->request->post()['masa'];
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
            'query' => PapanTanda::find()->where(['icno' => $icno])->andWhere(['isActive' => 1]),
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
            'query' => PapanTanda::find()->where(['icno' => $icno])->andWhere(['isActive' => 0]),
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
        return PapanTanda::find()->Where(['letter_sent' => [1,2]])->all();
    }
    
    // Senarai Menunggu Perakuan
    public function actionSemakanKj()
    { 
        $searchModel = new PapanTandaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $icno=Yii::$app->user->getId();
        $title = '';
        $senarai = '';   
        if(\app\models\aduan\RptTblAccess::find()->where( ['access_type' => 'urusetia', 'level' => '1'] )->exists()){
            $senarai = PapanTanda::find()->where(['app_by' => $icno])->andWhere(['status' => 'DALAM TINDAKAN KETUA JABATAN'])->orderBy(['entry_date' => SORT_ASC]);
            $title='Senarai Menunggu Perakuan';
        }    
        
        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        if($title!=NULL){ 
        return $this->render('semakan_kj', [
            'icno' => $icno,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title' => $title,
            'senarai' => $senarais,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
    public function actionTindakanKj($id)
    {
        $model = $this->findModel($id);
        $status = PapanTanda::findAll(['icno' => $model->icno]); //senarai status permohonan
        $pt = PapanTanda::findAll(['icno' => $model->icno, 'status' => ['LULUS']]);
        $icno = Yii::$app->user->getId(); 
        $default = Pegawai::find()->one();
        $today = date('Y-m-d');
        if ($model->load(Yii::$app->request->post())){
            
            $model->app_date = date('Y-m-d H:i:s');
            
            if (($model->status_kj == 'Diperakui' && ($model->ulasan_kj != ''))) { 
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah Diperakui!']);
            $model->status = 'LULUS';
            $this->notifikasi($model->icno, "Permohonan anda berjaya. ".Html::a('<i class="fa fa-arrow-right"></i>', ['semakan-permohonan'], ['class'=>'btn btn-primary btn-sm']));
            }
            
            elseif(($model->status_kj == 'Tidak Diperakui' && ($model->ulasan_kj != ''))) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Telah DITOLAK!']);
            $model->status = 'TIDAK LULUS';
            $this->notifikasi($model->icno, "Permohonan anda tidak berjaya. ".Html::a('<i class="fa fa-arrow-right"></i>', ['semakan-permohonan'], ['class'=>'btn btn-primary btn-sm']));
            }
            
            if($model->status_kj == '' || (($model->status_kj == 'Diperakui' && ($model->ulasan_kj == '')))|| (($model->status_kj == 'Tidak Diperakui' && ($model->ulasan_kj == '')))){
            Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Sila lengkapkan perakuan anda.']); 
            
            }
            else{ 
                
            $model->save();
            
            return $this->redirect(['semakan-kj', 'id' => $model->id]);
            
        }}   
        
        if($icno==$model->app_by){
        return $this->render('tindakan_kj', [
            'model' => $model,
            'icno' => $icno,
            'today' => $today,
            'status' => $status,
            'pt' => $pt,
            'bil' => 1,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
    
        // Senarai Rekod Perakuan
    public function actionRekodKj($icno=null, $statuskj=null)
    {               
        $icnoo=Yii::$app->user->getId();
        $title = '';
        $senarai = '';   
        if(SetPegawai::find()->where( ['peraku_icno' => $icnoo] || ['pelulus_icno' => $icnoo] )->exists()){
            $senarai = PapanTanda::find()->where(['app_by' => $icnoo])->orderBy(['entry_date' => SORT_ASC]);
            $title='Senarai Rekod Perakuan';
        }       
        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        
        $icno? $senarais->query->andFilterWhere(['icno' => $icno]):'';
        $statuskj? $senarais->query->andFilterWhere(['status_kj' => $statuskj]):'';
        
       if($title!=NULL){ 
        return $this->render('rekod_kj', [
            'icno' => $icno,
            'statuskj' => $statuskj,
            'icnoo' => $icnoo,
            'title' => $title,
            'senarai' => $senarais,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect('index');}
    }
}
