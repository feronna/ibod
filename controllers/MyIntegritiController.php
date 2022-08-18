<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use app\models\myintegriti\RefPenilaian;
use app\models\myintegriti\RefBhgnA;
use app\models\myintegriti\RefBhgnB;
use app\models\myintegriti\TblPenilaian;
use app\models\myintegriti\TblBhgnASearch;
use app\models\myintegriti\Tblprcobiodata;
use app\models\myintegriti\TblBiodataSearch;
use app\models\myintegriti\TblUserAccess;
use app\models\myintegriti\TblBhgnA;
use app\models\myintegriti\TblBhgnB;
use app\models\myintegriti\TblBhgnC;
use chrmorandi\jasper\Jasper;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use kartik\mpdf\Pdf;
use yii\web\HttpException;

class MyintegritiController extends \yii\web\Controller {
    
//    public function init() {
//        $this->layout = 'main_MyIntegriti';
//        
//        Yii::$app->errorHandler->errorAction = 'MyIntegriti/error';
//    }
    
    public function behaviors()
    {
       return [
           'access' => [
               'class' => AccessControl::className(),
               'only' => ['assessment', 'bahagiana', 'bahagianb', 'bahagianc', 'dashboard', 'view-assessment', 'penetapan-akses', 'akses', 'carian-borang', 'index'],
               'rules' => [
                   [
                       'actions' => ['assessment'],
                       'allow' => true,
                       'roles' => ['@'],
                       'matchCallback' => function ($rule, $action) {
                           $query = TblPenilaian::find()->where(['tahun' => date('Y')])->andWhere(['icno' => Yii::$app->user->identity->ICNO])->count();
                           $tmp = TblUserAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])->one();
                           //return ($query < 2 || (!is_null($tmp))) ? true : false;
                           if ($query < 2 || (!is_null($tmp))) {
                               return true;
                           }else {
                               throw new HttpException(403, "You have reached your limit for answering questions for today.");
                           }
                       }
                   ],
				   [
                       'actions' => ['bahagiana', 'bahagianb', 'bahagianc'],
                       'allow' => true,
                       'roles' => ['@'],
                       'matchCallback' => function ($rule, $action) {
                           $query = TblPenilaian::find()->where(['tahun' => date('Y')])->andWhere(['icno' => Yii::$app->user->identity->ICNO, 'status'=>2])->count();
                           //$tmp = TblUserAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])->one();
                           //return ($query < 2 || (!is_null($tmp))) ? true : false;
                           if ($query < 1) {
                               return true;
                           }else {
                               throw new HttpException(403, "You have reached your limit for answering questions for this year.");
                           }
                       }
                   ],
                   [
                       'actions' => ['dashboard', 'view-assessment', 'penetapan-akses', 'akses', 'carian-borang'],
                       'allow' => true,
                       'roles' => ['@'],
                       'matchCallback' => function ($rule, $action) {
                           $tmp = TblUserAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 99])->one();
                           return (is_null($tmp)) ? false : true;
                       }
                   ],
                   [
                       'actions' => ['index'],
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
    
//    public function actions() {
//        return [
//            'error' => [
//                'class' => 'yii\web\ErrorAction',
//            ],
//        ];
//    }
    
    public function actionIndex() {
        $borang = TblPenilaian::find()->where(['icno' => Yii::$app->user->getId()])->orderBy(['tahun' => SORT_DESC, 'created_dt' => SORT_DESC]);
        
        $provider = new ActiveDataProvider([
            'query' => $borang,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        
        return $this->render('index', ['dataProvider' => $provider, 'haspending' => TblPenilaian::haspending(Yii::$app->user->getId())]);
    }
     
    public function actionAssessment() {
        $model = new TblPenilaian();
        
        $bio = Tblprcobiodata::findOne(['ICNO' => Yii::$app->user->getId()]);
        
        $query = RefPenilaian::find()->orderBy(['id' => SORT_ASC]);
        
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);
        
        if($model->load((Yii::$app->request->post()))) {
         
            $sum_s = 0;
            $sum_a = 0;
            $sum_d = 0;
            $arry = RefPenilaian::find()->asArray()->all();
            
            //$model = new TblPenilaian();
            $model->icno = $bio->ICNO;
            $model->gred_id = $bio->gredJawatan;
            $model->dept_id = $bio->DeptId;
            $model->statlantikan = $bio->statLantikan;
            $model->tahun = date("Y");
            $model->created_dt = new \yii\db\Expression('NOW()');
                    
            foreach($arry as $index => $a){
                $qid = 'q'.($index + 1);
                //$model->$qid = $id;
                
                switch($a['code']) {
                    case 's':
                        $sum_s = $sum_s + $model->$qid;
                        break;
                    case 'a':
                        $sum_a = $sum_a + $model->$qid;
                        break;
                    case 'd':
                        $sum_d = $sum_d + $model->$qid;
                        break;
                }
            }
            
            $model->skor_s = $sum_s;
            $model->skor_a = $sum_a;
            $model->skor_d = $sum_d;
            
            $model->save(false);
            //\Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Borang berjaya dihantar!']);
            return $this->redirect(['result', 'id' => $model->id]);
        }
        
        return $this->render('borang', ['dataProvider' => $provider, 'model1' => $model]);
    }
	
	public function actionBahagiana($id=null) {
        
        if(!$id){
        $model = TblPenilaian::find()->where(['icno' => Yii::$app->user->getId(), 'status' => 1])->one();
        if(!$model){
            $model = new TblPenilaian(['icno' => Yii::$app->user->getId(), 'created_dt' => date('Y-m-d H:i:s'), 'tahun' => date('Y')]);
            $model->dept_id = $model->biodata->DeptId;
            $model->gred_id = $model->biodata->gredJawatan;
            $model->save(false);
        }}else{
            $model = TblPenilaian::find()->where(['id' => $id,'icno' => Yii::$app->user->getId()])->one();
        }
        
        $model1 = TblBhgnA::find()->where(['id_penilaian' => $model->id])->one(); 
        if(!$model1){      
            $model1 = new TblBhgnA(['id_penilaian' => $model->id]);
            $model1->save(false);
        }
        if (Yii::$app->request->post()) {	
            return $this->redirect(['bahagianb', 'id' => $model1->id_penilaian]);
        }
        $query = RefBhgnA::find()->orderBy(['id' => SORT_ASC]);
        
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);
        
        return $this->render('bhgna', ['dataProvider' => $provider, 'model1' => $model1, 'model' =>$model]);
    }
	
    public function actionBahagianb($id) {
        $model2 = TblBhgnB::find()->where(['id_penilaian' => $id])->one(); 
        if(!$model2){      
            $model2 = new TblBhgnB(['id_penilaian' => $id]);
            $model2->save(false);
        }
        
        $query = RefBhgnB::find()->orderBy(['id' => SORT_ASC]);
        if (Yii::$app->request->post()) {	
            return $this->redirect(['bahagianc', 'id' => $id]);
        }
        
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);
        
        return $this->render('bhgnb', ['dataProvider' => $provider, 'model2' => $model2, 'model' => TblPenilaian::find()->where(['id' => $id])->one()]);
    }
	
    public function actionBahagianc($id)
    {
        $model = TblBhgnC::find()->where(['id_penilaian' => $id])->one(); 
        if(!$model){      
            $model = new TblBhgnC(['id_penilaian' => $id]);
            $model->save(false);
        }

        $bio = Tblprcobiodata::findOne(['ICNO' => Yii::$app->user->getId()]);

        if ($model->load(Yii::$app->request->post())) {	
            $penilaian = TblPenilaian::find()->where(['id' => $id])->one();
            $penilaian->amanah = round($penilaian->amanahpoint*5,4);
            $penilaian->bijaksana = round($penilaian->bijaksanapoint*5,4);
            $penilaian->hemah = round($penilaian->hemahpoint*5,4);
            $penilaian->social_desirability = round($penilaian->sosialpoint*5,4);
            $penilaian->indeks_integriti = round($penilaian->amanahpoint*50+$penilaian->bijaksanapoint*30+$penilaian->hemahpoint*20,1);
            $penilaian->status = 2;
            $penilaian->created_dt = date('Y-m-d H:i:s');
            $penilaian->save(false);
            return $this->redirect(['result', 'id' => $model->id_penilaian]);
        }

        return $this->render('bhgnc', [
                'model' => $model,
                'id' => $id,
            'model1' => TblPenilaian::find()->where(['id' => $id])->one()
        ]);
    }
    
    public function actionViewAssessment($id) {
        $model = $this->findModel($id);
        
        //$bio = Tblprcobiodata::findOne(['ICNO' => Yii::$app->user->getId()]);
        
        $rubric = new RefPenilaian();
        
        $result = $this->findModel($id);
        
        foreach(array_reverse($rubric->depression_scale) as $key){
            if($result->skor_d >= $key['score']) {
                $d_msg = $key['status'];
                break;
            }
        }
        
        foreach(array_reverse($rubric->anxiety_scale) as $key){
            if($result->skor_a >= $key['score']) {
                $a_msg = $key['status'];
                break;
            }
        }
        
        foreach(array_reverse($rubric->stress_scale) as $key){
            if($result->skor_s >= $key['score']) {
                $s_msg = $key['status'];
                break;
            }
        }
        
        $bio = Tblprcobiodata::findOne(['ICNO' => $model->icno]);
        
        $query = RefPenilaian::find()->orderBy(['id' => SORT_ASC]);
        
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);
        
        return $this->render('view_borang', ['dataProvider' => $provider, 'model1' => $model, 'bio' => $bio
                , 'd_msg' => $d_msg, 'a_msg' => $a_msg, 's_msg' => $s_msg, 'result' => $result]);
    }
    
    public function actionGenerateAssessment($id) {
        
        $model = $this->findModel($id);
        
        //$bio = Tblprcobiodata::findOne(['ICNO' => Yii::$app->user->getId()]);
        
        $rubric = new RefPenilaian();
        
        $result = $this->findModel($id);
        
        foreach(array_reverse($rubric->depression_scale) as $key){
            if($result->skor_d >= $key['score']) {
                $d_msg = $key['status'];
                break;
            }
        }
        
        foreach(array_reverse($rubric->anxiety_scale) as $key){
            if($result->skor_a >= $key['score']) {
                $a_msg = $key['status'];
                break;
            }
        }
        
        foreach(array_reverse($rubric->stress_scale) as $key){
            if($result->skor_s >= $key['score']) {
                $s_msg = $key['status'];
                break;
            }
        }
        
        $bio = Tblprcobiodata::findOne(['ICNO' => $model->icno]);
        
        $query = RefPenilaian::find()->orderBy(['id' => SORT_ASC]);
        
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);
        
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $pdf = new Pdf([
            'filename' => $bio->CONm.'_MYINTEGRITI_'.$id,
            'mode' => Pdf::MODE_ASIAN, // leaner size using standard fonts
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('_borang', ['dataProvider' => $provider, 'model1' => $model, 'bio' => $bio
                , 'd_msg' => $d_msg, 'a_msg' => $a_msg, 's_msg' => $s_msg, 'result' => $result]),
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            'options' => [
                // any mpdf options you wish to set
            ],
            /*'methods' => [
                'SetTitle' => 'Privacy Policy - Krajee.com',
                'SetSubject' => 'Generating PDF files via yii2-mpdf extension has never been easy',
                'SetHeader' => ['Krajee Privacy Policy||Generated On: ' . date("r")],
                'SetFooter' => ['|Page {PAGENO}|'],
                'SetAuthor' => 'Kartik Visweswaran',
                'SetCreator' => 'Kartik Visweswaran',
                'SetKeywords' => 'Krajee, Yii2, Export, PDF, MPDF, Output, Privacy, Policy, yii2-mpdf',
            ]*/
        ]);
        return $pdf->render();
    }
    
    public function actionResult($id) {
        
        $result = $this->findModel($id);
        $bio = Tblprcobiodata::findOne(['ICNO' => $result->icno]);
      
        
        return $this->render('result', ['bio' => $bio, 'result' => $result]);
    }
    
    public function actionDashboard() {
        
        $array = TblPenilaian::find()->select([new Expression('COUNT(*) as jml'), 'created_dt as nama'])->where(['>=', 'created_dt', new Expression('(DATE(NOW()) - INTERVAL (WEEKDAY(DATE(NOW()))) DAY)')])
                ->andWhere(['<=', 'created_dt', new Expression('(DATE(NOW() + INTERVAL (6 - WEEKDAY(NOW())) DAY))')])->andWhere(['status' => 2])->groupBy(new Expression('CAST(`created_dt` as DATE)'))->asArray()->all();
        
        $male = TblPenilaian::find()->joinWith('biodata', false, 'LEFT JOIN')->where(['hronline.tblprcobiodata.GenderCd' => 'L', 'itg_tbl_penilaian.status' => 2])->count();
        
        $female = TblPenilaian::find()->joinWith('biodata', false, 'LEFT JOIN')->where(['hronline.tblprcobiodata.GenderCd' => 'P', 'itg_tbl_penilaian.status' => 2])->count();
        
        return $this->render('dashboard', ['model' => $array, 'male' => $male, 'female' => $female]);
    }
    
    public function actionPenetapanAkses() {
        $searchModel = new TblBiodataSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('akses_tetap', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionAkses($ICNO) {
        //$id = Yii::$app->user->getId(); 
        $bio = Tblprcobiodata::findOne(['ICNO' => $ICNO]);
        
        if(TblUserAccess::findOne(['icno' => $ICNO]) != null) {
            $model = TblUserAccess::findOne(['icno' => $ICNO]);
        }else {
            $model = new TblUserAccess();
        }
        
        if ($model->load(Yii::$app->request->post())) {
            $model->icno = $ICNO;
            if($model->access == 0) {
                $model->delete();
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Akses berjaya disimpan!']);
                return $this->redirect('penetapan-akses');
            }else {
                $model->save(false);
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Akses berjaya disimpan!']);
                return $this->redirect('penetapan-akses');
            }
            //$model->akses_oleh = $id;
        }
        
        return $this->renderAjax('kemaskini_akses', ['bio' => $bio, 'model' => $model]);
    }
    
    public function  actionCarianBorang() {
        $searchModel = new \app\models\myintegriti\TblPenilaianSearch();
            
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('cari_borang', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'rubric' => new RefBhgnA(),
        ]);
    }

    
    protected function findModel($id)
    {
        if (($model = TblPenilaian::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findModelUserAccess($id)
    {
        if (($model = TblUserAccess::find(['icno' => $id])) !== null) {
            return $model;
        }else {
            return $model = new TblUserAccess();
        }

        //throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function  actionSaveA($id, $val, $idpenilaian) {
        $model = TblBhgnA::find()->where(['id_penilaian' => $idpenilaian])->one();
        $model->id_penilaian = $idpenilaian;
        $model->$id = $val;
        $model->last_updated_dt = date('Y-m-d H:i:s');
        $model->save(false);
    }
    
    public function  actionSaveB($id, $val, $idpenilaian) {
        $model = TblBhgnB::find()->where(['id_penilaian' => $idpenilaian])->one();
        $model->id_penilaian = $idpenilaian;
        $model->$id = $val;
        $model->last_updated_dt = date('Y-m-d H:i:s');
        $model->save(false);
    }
    
    public function  actionSaveC($id, $val, $idpenilaian) {
        $model = TblBhgnC::find()->where(['id_penilaian' => $idpenilaian])->one();
        $model->id_penilaian = $idpenilaian;
        $model->$id = $val;
        $model->last_updated_dt = date('Y-m-d H:i:s');
        $model->save(false);
    }
    
    public function  actionSaveComment($val, $idpenilaian) {
        $model = TblBhgnC::find()->where(['id_penilaian' => $idpenilaian])->one();
        $model->id_penilaian = $idpenilaian;
        $model->komen = $val;
        $model->last_updated_dt = date('Y-m-d H:i:s');
        $model->save(false);
    }
}
