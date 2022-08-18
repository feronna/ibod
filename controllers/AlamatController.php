<?php

namespace app\controllers;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Tblalamat;
use app\models\hronline\TblpraddressSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\hronline\Negara;
use app\models\hronline\Negeri;
use app\models\hronline\Bandar;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * AlamatController implements the CRUD actions for Tblalamat model.
 */
class AlamatController extends Controller {

    /**
     * {@inheritdoc}
     */
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
                'only' => ['index', 'view','adminview', 'lihatalamat', 'adminlihatalamat', 'admintambahalamat', 'tambahalamat',
                            'update', 'adminupdate', 'delete', 'admindelete'],
                'rules' => [
                    Yii::$app->AccessManager->Allowed(Yii::$app->controller->id)
                    ,
                    [
                        'actions' => ['index', 'admintambahalamat', 'adminview', 'adminlihatalamat', 'adminupdate', 'admindelete'],
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
                                    if(in_array($secondaccess,['1','3'])){
                                        return true;
                                    }
                                    if(in_array($secondaccess,['4','5','6'])){
                                        return true;
                                    }
                                        return false;
                                    break;
                                case '3':
                                    if (in_array($secondaccess, ['7', '8', '9'])) {
                                        return true;
                                    }
                                    return false;
                                    break;
                                
                                default:
                                    return false;
                                    break;
                            }
                        }
                    ],
                    [
                        'actions' => ['lihatalamat', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $icno = Yii::$app->user->getId();
                            $id = Yii::$app->request->get('id');
                            $check = Tblalamat::findAll(['id' => $id, 'ICNO' => $icno]);
                            $boleh = false;
                            if (!empty($check)) {
                                $boleh = true;
                            }

                            return $boleh === true;
                        }
                    ],
                    [
                        'actions' => ['view', 'tambahalamat'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Tblpraddress models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new TblpraddressSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionView() {
        $icno = Yii::$app->user->getId();
        return $this->render('view', [
            'alamat' => Tblalamat::findAll(['ICNO' => $icno]),
        ]);
    }
    
    public function actionAdminview($icno) {
        if($this->findModel($icno)){
           return $this->render('adminview', [
               'alamat' => Tblalamat::findAll(['ICNO' => $icno]), 
               'ICNO' => $icno]); 
        }
        
    }

    public function actionLihatalamat($id) {
        return $this->render('lihatalamat', [
                    'model' => $this->findModelbyid($id),
        ]);
    }
    
    public function actionAdminlihatalamat($id) {
        return $this->render('adminlihatalamat', [
                    'model' => $this->findModelbyid($id),
        ]);
    }

    public function actionTambahalamat($samadengan = null, $tambah = null) {
        $model = new Tblalamat();
        $model->ICNO = Yii::$app->user->getId();
        if($samadengan != null){
            $alamat = Tblalamat::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['AddrTypeCd' => $samadengan])->one();
            $data = $alamat->attributes;
            $model->setAttributes($data);
            $model->AddrTypeCd = $tambah;
            if($model->save()){
                return $this->redirect(['view']);  
            }
        }
        
        $alamat_exist = Tblalamat::find()->where(['ICNO'=>Yii::$app->user->getId()])->andWhere(['AddrTypeCd'=>'01'])->exists();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view']);   
        }
        return $this->render('tambahalamat', [
                    'model' => $model,
                    'alamat' => $alamat_exist,
        ]);
    }
    
    public function actionAdmintambahalamat($icno, $samadengan = null, $tambah = null) {
        $model = new Tblalamat();
        $model->ICNO = $icno;
        if($samadengan != null){
            $alamat = Tblalamat::find()->where(['ICNO' => $icno])->andWhere(['AddrTypeCd' => $samadengan])->one();
            $data = $alamat->attributes;
            $model->setAttributes($data);
            $model->AddrTypeCd = $tambah;
            if($model->save()){
                return $this->redirect(['adminview', 'icno' => $model->ICNO]);  
            }
        }
        $alamat_exist = Tblalamat::find()->where(['ICNO'=>Yii::$app->user->getId()])->andWhere(['AddrTypeCd'=>'01'])->exists();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {           
            return $this->redirect(['adminview', 'icno' => $model->ICNO]);
        }

        if($this->findModel($icno)){
           return $this->render('admintambahalamat', [
                    'model' => $model,
                    'alamat' => $alamat_exist,
           ]); 
        }
        
    }

    public function actionUpdate($id) {
        $model = $this->findModelbyid($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view']);
        }
        return $this->render('update', [
                    'model' => $model,
        ]);
    }
    
    public function actionAdminupdate($id) {
        $model = $this->findModelbyid($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['adminview', 'icno' => $model->ICNO]);
        }
        return $this->render('adminupdate', [
                    'model' => $model,
        ]);
    }

    public function actionDelete($id) {
        $model = $this->findModelbyid($id);
        $model->delete();
        return $this->redirect(['view']);
    }
    
    public function actionAdmindelete($id) {
        $model = $this->findModelbyid($id);
        $model->delete();
        return $this->redirect(['adminview', 'icno' => $model->ICNO]);
    }

    protected function findModelbyid($id) {
        if (($model = Tblalamat::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findModel($icno) {
        if (($model = Tblprcobiodata::findOne($icno)) !== null) {
            return true;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }


    ////action for dependent dropdown
    public function actionStatelist() {
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

    public function actionCitylist() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $out = Bandar::find()->select(['id' => 'CityCd', 'name' => 'City'])->where(['StateCd' => $cat_id])->asArray()->all();

                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

}
