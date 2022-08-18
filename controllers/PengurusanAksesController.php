<?php

namespace app\controllers;

use app\models\hronline\TblPapAkses;
use app\models\hronline\TblPapSenaraiStaf;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use app\models\hronline\TblPapTindakan;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class PengurusanAksesController extends \yii\web\Controller
{
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['*'],
                'rules' => [
                    Yii::$app->AccessManager->Allowed(Yii::$app->controller->id),
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $provider = new ActiveDataProvider([
            'query' => TblPapSenaraiStaf::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index',[
        'model' => $provider,    
        ]);
    }

    public function actionPenamatanAkses(){

        $searchModel = new TblPapSenaraiStaf();
        $dataProvider = $searchModel->searchPenamatanAkses(Yii::$app->request->queryParams);

        return $this->render('penamatan_akses/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLihatStaf($id){

        $model = $this->findModel($id);
        
        return $this->render('penamatan_akses/lihat',[
            'model' => $model,
        ]);

    }

    public function actionKemaskini($id){

        $model = $this->findModel($id);
        $model->_action = 'kemaskini penamatan_akses';

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect([
                    'penamatan_akses/lihat-staf',
                    'id' => $id,
                ]);
            }
        }
        
        return $this->render('penamatan_akses/_borang',[
            'model' => $model,
        ]);
        
    }

    public function actionTindakan($id){
        $model = $this->findModel($id);

        if(!$tindakan = $this->findTindakanIndividu($id)){
            $tindakan = new TblPapTindakan();
        }

        if($tindakan->load(Yii::$app->request->post())){
            $tindakan->pap_ss_id = $model->id;
            $tindakan->icno_staf = Yii::$app->user->getId();
            $tindakan->nama_staf = Yii::$app->user->identity->CONm;
            if($tindakan->save()){
                return $this->redirect(['lihat-staf',
                    'id'=>$id,
                ]);
            }
        }

        return $this->render('tindakan/borang_tindakan',[
            'tindakan' => $tindakan,
        ]);
    }

    public function actionTindakanSelesai($id){ //id pap_tindakan
        
        $tindakan = $this->findTindakan($id);
        $tindakan->status = 1;
        $tindakan->tandatangan = Yii::$app->user->identity->CONm;
        $tindakan->tarikh_selesai = date('Y-m-d');
        if($tindakan->save()){
            
        }

        return $this->redirect(['lihat-staf',
            'id' => $tindakan->pap_ss_id,
        ]);
    }
    public function actionTindakanBelumSelesai($id){ //id pap_tindakan
        
        $tindakan = $this->findTindakan($id);
        $tindakan->status = 0;
        $tindakan->tandatangan = Yii::$app->user->identity->CONm;
        $tindakan->tarikh_selesai = date('Y-m-d');
        if($tindakan->save()){
            
        }

        return $this->redirect(['lihat-staf',
            'id' => $tindakan->pap_ss_id,
        ]);
    }
    public function actionAdminLihatStaf($id){ //id pap_tindakan
        
        $model = $this->findModel($id);
        
        return $this->render('admin/lihat',[
            'model' => $model,
        ]);
    }

    //pengurusan gmail//

    public function actionPengurusanGmail(){

        $searchModel = new TblPapSenaraiStaf();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('pengurusan_gmail/index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
    }
    public function actionPGTindakan($id){
        $model = $this->findModelPG($id);

        if(!$tindakan = $this->findTindakanIndividu($id,4)){
            $tindakan = new TblPapTindakan();
        }

        $tindakan->_action = 'PGTindakan';

        if($tindakan->load(Yii::$app->request->post())){
            $tindakan->pap_ss_id = $model->id;
            $tindakan->icno_staf = Yii::$app->user->getId();
            $tindakan->nama_staf = Yii::$app->user->identity->CONm;
            $tindakan->tandatangan = Yii::$app->user->identity->CONm;
            if($tindakan->status == 1){
                $tindakan->tarikh_selesai = date('Y-m-d');
            }

            if($tindakan->save()){
                return $this->redirect(['pengurusan-gmail'
                ]);
            }
        }

        return $this->render('pengurusan_gmail/_borangTindakan',[
            'tindakan' => $tindakan,
            'model' => $model,
        ]);
    }

    public function actionPGLihat($id){
        $model = $this->findModelPG($id);
        
        return $this->render('pengurusan_gmail/lihat',[
            'model' => $model,
        ]);
    }


    //tamat pengurusan gmail//

    

    protected function findModel($id) {
        if (($model = TblPapSenaraiStaf::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findModelPG($id) {
        if (($model = TblPapSenaraiStaf::find()->where(['id'=>$id])->andWhere(['sebab_perubahan'=>'Lantikan Baru'])->andWhere(['>','tarikh_ubah','2022-04-01'])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findTindakan($id) {
        if (($model = TblPapTindakan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findTindakanIndividu($id,$jenis_akses = null) {

        if ($this->findModelPG($id)) {
            if($jenis_akses != null){
                ($tindakan = TblPapTindakan::find()->where(['pap_ss_id' => $id])->andWhere(['jenis_akses' => $jenis_akses])->one()) !== null;
                return $tindakan;
            }

            if (($tindakan = TblPapTindakan::find()->joinWith('akses')->where(['pap_ss_id' => $id])->andWhere(['`ref_pap_jenis_akses`.`pentadbir`' => Yii::$app->user->getId()])->one()) !== null) {
                return $tindakan;
            }
            return false;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findTindakanAdmin($id) {
        if ($this->findModel($id)) {
            if (($tindakans = TblPapTindakan::find()->where(['pap_ss_id' => $id])->all()) !== null) {
                return $tindakans;
            }
            return false;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    



}
