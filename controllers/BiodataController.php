<?php

namespace app\controllers;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;
use app\models\hronline\Jabatan;
use app\models\hronline\Gelaran;
use app\models\hronline\Negeri;
use app\models\hronline\TblprcobiodataSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Notification;
use yii\helpers\Json;
use yii\filters\AccessControl;
use app\models\hronline\Tblretireage;
use app\models\hronline\Umsper;
use app\models\hronline\AksesLevelkedua;
use app\models\hronline\AksesLevel;
use yii\rbac\DbManager;
use app\models\hronline\ResetMyPassword;
use app\models\hronline\TblAdminRP;
use app\models\hronline\Tblrscoadminpost;
use yii\helpers\VarDumper;

class BiodataController extends Controller {

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
                'only' => ['index','adminview', 'userview', 'lihatbiodata','lihatbiodatakakitangan', 'tambahkakitangan','kemaskinikakitangan','kemaskini',
                            'penetapanpengguna', 'kemaskinipenetapanpengguna','padamkakitangan','resetpassword', 'admin-reset-password','view-a-r-p','index','ketua-program-view',
                            'kemaskinikakitangan-kprogram','sync-to-ad','admin-carian-staf','view-a-r-p','sync-to-grp'],
                'rules' => [
                    Yii::$app->AccessManager->Allowed(Yii::$app->controller->id),
                    
                    [
                        'actions' => ['index','adminview', 'tambahkakitangan','lihatbiodatakakitangan','kemaskinikakitangan','penetapanpengguna', 'kemaskinipenetapanpengguna',
                                      'resetpassword','sync-to-grp'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                           
                           $access = Yii::$app->user->identity->accessLevel;
                           $secondaccess = Yii::$app->user->identity->accessSecondLevel;
                           
                           switch ($access) {
                                case '1':
                                      return true;
                                    break;
                                case '2':
                                    if (in_array($secondaccess,['1','3'])) {

                                        return true;
                                    }
                                    if(in_array($secondaccess,['4','5','6'])){
                                        return true;
                                    }
                                    return false;
                                    break;
                                case '3':
                                    if (in_array($secondaccess,['7','8', '9'])) {

                                        return true;
                                    }
                                    return false;
                                    break;

                                default:
                                    return false;
                                    break;
                            }  

                            return false;
                        }
                    ],
                    [
                        'actions' => ['userview','kemaskini','lihatbiodata'],
                        'allow' => true,
                        'roles' => ['@'],  
                    ],
                    [
                        'actions' => ['admin-carian-staf','view-a-r-p'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $icno = Yii::$app->user->getId();
                            $perm = TblAdminRP::find()->where(['icno'=>$icno])->one();
                            if($perm){
                                return true;
                            }
                            return false;
                        }
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            Yii::$app->request->get('id');
                            if(Yii::$app->MP->isKetuaProgram()){
                                return true;
                            }
                            return false;
                        }
                    ],
                    [
                        'actions' => ['ketua-program-view','kemaskinikakitangan-kprogram'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if(Yii::$app->MP->isKetuaProgram() && Yii::$app->MP->isInSameProgram(Yii::$app->request->get('id'))){
                                return true;
                            }
                            return false;
                        }
                    ],

                ],
            ],
        ];
    }

    public function actionGenerate(){
        $model = Tblprcobiodata::find()->all();
        foreach ($model as $m) {
            if(empty($m->DisplayIC)){
                $m->DisplayIC = $m->ICNO;
                $m->save(false);
            }
            
        }

        echo "berjaya";
    }

    public function actionIndex() {      
        $carian = new TblprcobiodataSearch();
        $dataProvider = $carian->carian(Yii::$app->request->queryParams);  

        return $this->render('index', [
                    'carian' => $carian,
                    'model' => $dataProvider,
        ]);
   
    }
    
    public function actionUserview() {
        $id = Yii::$app->user->getId();
        $model = $this->findModel($id);
        return $this->render('view_user', [
                    'model' => $model,
        ]);
    }
    
    public function actionAdminview($id) {
        $model = $this->findModel($id); 
        return $this->render('view_admin', [
                    'model' => $model,
        ]);
    }

    

    public function actionLihatbiodata() {
        $id = Yii::$app->user->getId();
        return $this->render('lihatbiodata', [
                    'model' => $this->findModel($id),
        ]);
    }
    
    public function actionLihatbiodatakakitangan($id) {
        return $this->render('lihatbiodatakakitangan', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionPenetapanpengguna($icno){
      $model = Tblprcobiodata::findOne(['ICNO'=>$icno]);

       return $this->render('penetapanpengguna',['model'=>$model]);
    }

    public function actionKemaskinipenetapanpengguna($id){
        $model = Tblprcobiodata::findOne(['ICNO'=>$id]);

        if ($model->load(Yii::$app->request->post()) ) {
           
           if(empty($model->accessSecondLevel)){

               $model->accessSecondLevel = 0;
           }
           if ($model->save()) {
               Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Tetapan Capaian Pengguna Dikemaskini!']);
                 return $this->redirect(['penetapanpengguna','icno'=>$model->ICNO]);
           }
           Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Tetapan Capaian Pengguna Gagal Dikemaskini!']);
           return $this->redirect(['penetapanpengguna','icno'=>$model->ICNO]);
           
        }

        return $this->render('kemaskinipenetapanpengguna',['model'=>$model]);
    }

    public function actionResetpassword($id){
        $model = Tblprcobiodata::findOne(['ICNO'=>$id]);
        $new_id = substr($model->COOldID, -5). substr($id, -4);
        $model->COOPass =  md5($new_id);
        if ($model->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Katalaluan berjaya dikemaskini!']);

        }else{
            Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'Kata Laluan tidak berjaya ditukar!']);
        }
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
        //return $this->redirect(['penetapanpengguna','icno'=>$model->ICNO]);

    }

    public function actionChangeMyPassword(){
        $model = $this->findModel(Yii::$app->user->getId());
        $reset_password = new ResetMyPassword();

        if($reset_password->load(Yii::$app->request->post())){
            if(md5($reset_password->old_pass) == $model->COOPass){
                if($reset_password->new_pass1 == $reset_password->new_pass2){

                    $model->COOPass = md5($reset_password->new_pass1);
                    $model->save(false);
                    Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Katalaluan berjaya dikemaskini! Sila log masuk semula menggunakan katalaluan baru.']);
                    Yii::$app->view->registerMetaTag([
                        'http-equiv'=>'refresh',
                        'content' => '3,url=logout'
                    ]);
                }else{
                    Yii::$app->session->setFlash('invalid_password', "Katalaluan tidak sama!");
                }
            }else{
                Yii::$app->session->setFlash('invalid_old_password', "Katalaluan salah!");
            }
        }

        return $this->render('resetmypassword',[
            'reset_password' => $reset_password,
        ]);

    }

    public function actionLogout(){
        return $this->redirect(['site/logout']);
    }

    public function actionAdminCarianStaf(){
        $carian = new Tblprcobiodata();
        $dataProvider = $carian->carianARP(Yii::$app->request->queryParams);  

        return $this->render('adminresetpassword', [
                    'carian' => $carian,
                    'model' => $dataProvider,
        ]);

    }

    public function actionViewARP($id){

            return $this->renderAjax('viewARP', [
                'model' => $this->findModel($id),
            ]);

    }


    public function actionConfirmtosave() {

        $icno = Yii::$app->user->getId();
        $model = new Tblprcobiodata();
        $ntf = new Notification();
        $ntf->icno = $icno;

        if ($model->load(Yii::$app->request->post())) {

            $model->save();

            return $this->redirect(['adminview', 'id' => $model->ICNO]);
        }

        return $this->render('tambahKakitangan', [
                    'model' => $model,
        ]);
    }
    
    public function actionKemaskinikakitangan($id) {
        $model = $this->findModel($id);
        $model->scenario = 'kemaskini';
        if ($model->load(Yii::$app->request->post())) {
            if($model->NatStatusCd != '1'){
                $model->COBumiStatus = '0';
            }
            if($model->save()){
                return $this->redirect(['adminview', 'id' => $model->ICNO]);
            }
        }
        return $this->render('kemaskinikakitangan', [
                    'model' => $model,
        ]);
    }
    
    public function actionKemaskini() {
        $id = Yii::$app->user->getId();
        $model = $this->findModel($id);
        $model->scenario = 'kemaskini';
        if ($model->load(Yii::$app->request->post()) ) {

            if($model->save()){
                return $this->redirect(['lihatbiodata']);
            }

            // var_dump( $model->errors);
            // die;
            
        }
        return $this->render('kemaskini', [
                    'model' => $model,
        ]);
    }

    public function actionPadamkakitangan($id) {
        //$this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    //ketua program//
    public function actionKetuaProgramView($id){
        $model = $this->findModel($id); 
        return $this->render('ketua_program/lihatbiodatakakitangan', [
                    'model' => $model,
        ]);
    }

    public function actionKemaskinikakitanganKprogram($id){
        $model = $this->findModel($id);
        $model->scenario = 'kemaskini_by_kprogram';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('ketua_program/kemaskinikakitangan', [
                    'model' => $model,
        ]);
    }

    //tamat ketua program//

    //Active Directory//
    public function actionSyncToAd($id){
        $biodata = $this->findModel($id);
        $ad = substr($biodata->COEmail, 0, strpos($biodata->COEmail, '@'));
    
        $res = Yii::$app->ActiveDirectory->Update($ad,$id);
        if($res->status){
            Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Data hronline berjaya dikemaskini ke AD.']);                   
        }else{
            if(empty($res->errors)){
                $message = $res->message;
            }else{
                $message = $res->errors[0];
            }
            Yii::$app->session->setFlash('alert', ['title' => ' Gagal', 'type' => 'error', 'msg' => $message]);                   
        }
        return $this->redirect(['penetapanpengguna',
            'icno' => $id,
        ]);
    }

    //tamat Active Directory//

    //grp9//
    public function actionSyncToGrp($id){

        $response = Yii::$app->GRP->EmployeeRegister($id);
        VarDumper::dump( $response, $depth = 10, $highlight = true);
        die;

    }
    //tamat grp9//

 
    protected function findModel($id) {
        if (($model = Tblprcobiodata::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCitylist() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $out = Negeri::find()->select(['id' => 'StateCd', 'name' => 'State'])->where(['CountryCd' => $cat_id])->asArray()->all();

                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    public function actionPeringkatcapaiankedua() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $out = AksesLevelkedua::find()->select(['id' => 'id', 'name' => 'nama'])->where(['jenis' => $cat_id])->asArray()->all();

                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }
    

}
