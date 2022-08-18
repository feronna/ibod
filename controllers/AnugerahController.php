<?php

namespace app\controllers;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Tblanugerah;
use app\models\hronline\TblanugerahSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\hronline\Negeri;
use yii\filters\AccessControl;
use yii\helpers\Json;


/**
 * AnugerahController implements the CRUD actions for Tblanugerah model.
 */
class AnugerahController extends Controller
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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'adminview', 'adminlihatanugerah', 'admintambahanugerah', 'adminupdate', 'admindelete',
                           'view','lihatanugerah','tambahanugerah','update','delete'],
                'rules' => [
                    Yii::$app->AccessManager->Allowed(Yii::$app->controller->id)
                    ,
                    [
                        'actions' => ['index', 'adminview', 'adminlihatanugerah', 'admintambahanugerah','adminupdate', 'admindelete'],
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
                        'actions' => ['lihatanugerah', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $logicno = Yii::$app->user->getId();
                            $id = Yii::$app->request->get('id');
                            $check = Tblanugerah::findAll(['awdId' => $id, 'ICNO' => $logicno]);
                            $boleh = false;
                            if (!empty($check)) {
                                $boleh = true;
                            }

                            return $boleh === true;
                        }
                    ],
                    [
                        'actions' => ['view', 'tambahanugerah'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Tblanugerah models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TblanugerahSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tblanugerah model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(){
        $icno = Yii::$app->user->getId();
        return $this->render('view', [
            'anugerah' => Tblanugerah::findAll(['ICNO' => $icno]),
        ]);
    }
    public function actionAdminview($icno){
        if($this->findModel($icno)){
            return $this->render('adminview',[
            'anugerah' => Tblanugerah::findAll(['ICNO' => $icno]),
            'ICNO' => $icno,
        ]);
        }
        
    }
    
    public function actionLihatanugerah($id){
        return $this->render('lihatanugerah', [
            'model' => $this->findModelbyid($id),  
        ]);
    }
    public function actionAdminlihatanugerah($id){
        return $this->render('adminlihatanugerah', [
            'model' => $this->findModelbyid($id),  
        ]);
    }

    public function actionTambahanugerah(){
        $icno = Yii::$app->user->getId();
        $model = new Tblanugerah();
        if ($model->load(Yii::$app->request->post())) {
            $model->ICNO = $icno;
            if($model->save()){
              return $this->redirect(['view']);  
            } 
        }
        return $this->render('tambahanugerah', [
            'model' => $model
        ]);        
    }
    
    public function actionAdmintambahanugerah($icno){
        
        $model = new Tblanugerah();
        $model->ICNO = $icno;
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
              return $this->redirect(['adminview', 'icno' => $icno]);  
            } 
        }
        if($this->findModel($icno)){
           return $this->render('admintambahanugerah', [
            'model' => $model,
        ]); 
        }
        
    }

    public function actionUpdate($id){
        $model = $this->findModelbyid($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            return $this->redirect(['view']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    
    public function actionAdminupdate($id){
        $model = $this->findModelbyid($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            return $this->redirect(['adminview', 'icno' => $model->ICNO]);
        }

        return $this->render('adminupdate', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id){
        $model = $this->findModelbyid($id);
        if($model->delete()){
            return $this->redirect(['view']);
        }   
    }
    public function actionAdmindelete($id){
        $model = $this->findModelbyid($id);
        if($model->delete()){
            return $this->redirect(['adminview', 'icno' => $model->ICNO]);
        }
    }
    
   
    
    protected function findModelbyid($id)
    {
        if (($model = Tblanugerah::findOne(['awdId' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findModel($id) {
        if (($model = Tblprcobiodata::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
     public function actionList_negeri($negara) {
         
        
        $kiranegeri = Negeri::find()->where(['CountryCd' => $negara])->count();
        
        $negeri = Negeri::find()->where(['CountryCd' => $negara])->all();
        if($kiranegeri > 0){
            foreach ($negeri as $result){
                echo "<option value='.$result->StateCd.'>".$result->State."</option>";
            }
        }else{
            echo "<option value='00'>Lain-lain</option>";
        }
    }
    
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
}
