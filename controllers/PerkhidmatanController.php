<?php

namespace app\controllers;
use yii\data\ActiveDataProvider;
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
use app\models\hronline\Tblrscoapmtstatus;
use app\models\hronline\Tblrscosandangan;
use app\models\hronline\Tblrscoservstatus;
use app\models\hronline\Updatestatus;
use yii\widgets\LinkPager;
use yii\data\Pagination;

/**
 * BiodataController implements the CRUD actions for Tblprcobiodata model.
 */
class PerkhidmatanController extends Controller {
    

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
     * Lists all Tblprcobiodata models.
     * @return mixed
     */
//       public function actionIndex() {
//       $model1 = new Tblprcobiodata();
//     //  $model = Tblprcobiodata::find()->limit(20)->all();
//       
//       $query = Tblprcobiodata::find();
//       $countQuery = clone $query;
//       $pages = new Pagination(['totalCount' => $countQuery->count()]);
//       $model = $query->offset($pages->offset)
//        ->limit($pages->limit)
//        ->all();
//
//        
//        if (Yii::$app->request->post('cari')) {
//            $data = Yii::$app->request->post('search');
//            
//             $model = Tblprcobiodata::find()->where(['LIKE','CONm',$data])->limit(50)->all();
//             if(empty($model)){
//                 $model = Tblprcobiodata::find()->where(['LIKE','ICNO',$data])->limit(50)->all();
//             }
//           
//        }
//        
//        
//        return $this->render('index', [
//                   'model' => $model,
//                    'model1' => $model1,'pages' => $pages
//        ]);
//    }
    
    
    
     public function actionIndex() {        
        $carian = new TblprcobiodataSearch();
        $dataProvider = $carian->carian(Yii::$app->request->queryParams);  

        return $this->render('index', [
                    'carian' => $carian,
                    'model' => $dataProvider,
        ]);
   
    }

    public function actionRedirectview() {
        $id = Yii::$app->user->getId();
       
        return $this->redirect(['view','id'=>$id]);
    }
       public function actionRedirectviews($id) {
        $id = $id;
        
        return $this->redirect(['view','id'=>$id]);  
    }
    
       public function actionView($id) {
       // $self = Yii::$app->user->getId();
        $model = $this->findModel($id);
         
          $usern = $id;
         $query= Updatestatus::find()->where(['usern' => $usern])->orderBy(['COUpadteDate' => SORT_DESC]);
       
           $provider = new ActiveDataProvider([
           'query' => $query,
           'pagination' => [
           'pageSize' =>  5
           ],
            
       ]);
        return $this->render('view', [
                    'model' => $model,'provider' => $provider
        ]);
    }
    
       public function actionViewuser() {
        $id = Yii::$app->user->getId();
        $model = $this->findModel($id);
        
          $usern = $id;
         $query= Updatestatus::find()->where(['usern' => $usern])->andFilterWhere(['like', 'COTableName','tblrs'])->orderBy(['COUpadteDate' => SORT_DESC]);
          
           $provider = new ActiveDataProvider([
           'query' => $query,
           'pagination' => [
           'pageSize' =>  5
           ],
            
       ]);
        return $this->render('viewuser', [
                    'model' => $model,'provider' => $provider
        ]);
    }
    
   
   

    public function actionLihatbiodata($id) {
        return $this->render('lihatbiodata', [
                    'model' => $this->findModel($id),
        ]);
    }
    public function actionLihatbiodatakakitangan($id) {
        return $this->render('lihatbiodatakakitangan', [
                    'model' => $this->findModel($id),
        ]);
    }


    /**
     * Creates a new Tblprcobiodata model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionTambahkakitangan() {
        $model = new Tblprcobiodata();
        $icno = Yii::$app->user->getId();
        $ntf = new Notification();
        $ntf->icno = $icno;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['view', 'id' => $model->ICNO]);
        }

        return $this->render('tambahKakitangan', [
                    'model' => $model,
        ]);
    }

    public function actionConfirmtosave() {

        $icno = Yii::$app->user->getId();
        $model = new Tblprcobiodata();
        $ntf = new Notification();
        $ntf->icno = $icno;

        if ($model->load(Yii::$app->request->post())) {

            $model->save();

            return $this->redirect(['view', 'id' => $model->ICNO]);
        }

        return $this->render('tambahKakitangan', [
                    'model' => $model,
        ]);
    }


    public function actionTreeStat($id=null){
        $tree = [];
        if(!empty($id)){
            $model = Tblprcobiodata::findOne($id);

            $status_lantikan = Tblrscoapmtstatus::find()->where(['ICNO'=>$id])->all(); 
            if(!empty($status_lantikan)){
                foreach ($status_lantikan as $st) {
                   $sl = [
                       'title'=>$st->statusLantikan->ApmtStatusNm,
                       'byline' => $st->ApmtStatusStDt,
                       
                   ];
                   array_push($tree, $sl);
                }
            }

            $sandangan = Tblrscosandangan::find()->where(['ICNO'=>$id])->all(); 
            if(!empty($sandangan)){
                foreach ($sandangan as $s) {
                   $sl = [
                       'title'=>$s->statusSandangan->sandangan_name . ' [ '. $s->gredJawatan->fname.' ] ',
                       'byline' => $s->start_date,
                   ];
                   array_push($tree, $sl);
                }
            }

            $status_perkhidmatan = Tblrscoservstatus::find()->where(['ICNO'=>$id])->all(); 
            if(!empty($status_perkhidmatan)){
                foreach ($status_perkhidmatan as $sp) {
                   $sl = [
                       'title'=>$sp->statusPerkhidmatan->ServStatusNm ,
                       'byline' => $sp->ServStatusStDt,
                   ];
                   array_push($tree, $sl);
                }
            }

            
        }
        $tree = $this->bubbleSort($tree);
        // var_dump($tree);
        // die;
        for($i = 0; $i < count($tree); $i++){
            $tree[$i]['byline'] = Yii::$app->MP->Tarikh($tree[$i]['byline']);
        }

        return $this->renderAjax('treestat',[
            'tree'=>$tree,
            'bio' => $model,
        ]);
    }

    private function bubbleSort($array){
        $tree = [];
        for ($i=0; $i < count($array); $i++) { 
            
            for ($j=0; $j < count($array); $j++) { 
                if(strtotime($array[$i]['byline']) > strtotime($array[$j]['byline']) &&  $i < $j ){
                    // echo "</br>";
                    // echo $i;
                    // echo "</br>";
                    // echo $j;
                    // echo "</br>";
                    // echo $array[$i]['content']." > ".$array[$j]['content'];
                    // echo "</br>";
                    // echo "array length = ".count($array);
                 
                    $temp = $array[$i];
                    $array[$i] = $array[$j];
                    $array[$j] = $temp;
                }
                else if(strtotime($array[$i]['byline']) == strtotime($array[$j]['byline']) &&  $i < $j){
                    
                    // echo "</br>";
                    // echo $i;
                    // echo "</br>";
                    // echo $j;
                    // echo "</br>";
                    // echo $array[$i]['content']." = ".$array[$j]['content'];
                    // echo "</br>";
                    // echo "buang ".$array[$j]['content'] ;
                   
                    // $array[$i]['title'] = $array[$i]['title'] .' '. $array[$j]['title'];
                    // array_splice($array,$j,1);
                   
                    // $j--;
                     // echo "</br>";
                    // echo "array length = ".count($array);
                    // echo "</br>";
                    // var_dump($array);
                    // die;
                } 
                else{
                    // echo "</br>";
                    // echo $i;
                    // echo "</br>";
                    // echo $j;
                    // echo "</br>";
                    // echo $array[$i]['content']." <= ".$array[$j]['content'];
                    // echo "</br>";
                    // echo "array length = ".count($array);
                }
            }
        }

        // die;
        return $array;
    }


    /**
     * Updates an existing Tblprcobiodata model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionKemaskinikakitangan($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ICNO]);
        }
        return $this->render('kemaskinikakitangan', [
                    'model' => $model,
        ]);
    }
    
    public function actionKemaskini($id) {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ICNO]);
        }
        return $this->render('kemaskini', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Tblprcobiodata model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionPadamkakitangan($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tblprcobiodata model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Tblprcobiodata the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Tblprcobiodata::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function getStaffDepartment() {

        $JabatanKakitangan = Jabatan::findOne([$id => $model->deptId]);

        return $JabatanKakitangan;
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
    
    

}
