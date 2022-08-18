<?php

namespace app\controllers;
use yii\filters\AccessControl;
use Yii;
use app\models\vhrms\ViewPayroll;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\hronline\Tblprcobiodata;
use yii\helpers\ArrayHelper;
use app\models\hronline\StatusLantikan;
use app\models\hronline\Tblrscoapmtstatus;
use app\models\hronline\TblStaffSalary;
use app\models\hronline\RefEpfType;
use app\models\hronline\RefTaxFormulaType;
use app\models\hronline\RefTaxCategory;
use app\models\hronline\RefSocsoType;
use yii\data\ActiveDataProvider;


error_reporting(0);
/**
 * JenisPerkhidmatanController implements the CRUD actions for tblrscoservtype model.
 */
class ProfilGajiController extends Controller
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
     * Lists all tblrscoservtype models.
     * @return mixed
     */
 

 
      public function actionView($umsper) {
      $model = TblStaffSalary::find()->where(['SS_STAFF_ID' => $umsper])->all();
      $models = Tblprcobiodata::find()->where(['COOldID' => $umsper])->one();
        return $this->render('view',['model' => $model, 'models' => $models]);
      
    }   //('Jumlah Gaji', ['jumlah-gaji/view', 'COOldID' => $model->COOldID]) 

    /**
     * Creates a new tblrscoservtype model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
 
    public function actionCreate()
    {
        $model = new ViewPayroll();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing tblrscoservtype model.
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

    /**
     * Deletes an existing tblrscoservtype model.
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
    
     public function actionRedirectview() {
        $id = Yii::$app->user->getId();
       
        return $this->redirect(['view','id'=>$id]);
    }
    
    public function actionRedirectviews($COOldID) {
        $id = $COOldID;
        
        return $this->redirect(['view','id'=>$id]);  
    }
    
       public function actionTambahProfilGaji($umsper) {
        $biodata= Tblprcobiodata::find()->where(['COOldID' => $umsper])->one();
        $model1 = ViewPayroll::find()->where(['MPH_STAFF_ID' => $umsper])->one();
        $lantikan =  ArrayHelper::map(StatusLantikan::find()->all(), 'ApmtStatusCd', 'ApmtStatusNm');
        $formula_cukai =  ArrayHelper::map(RefTaxFormulaType::find()->all(), 'TFT_FORMULA_TYPE_CODE', 'TFT_DESC');
        $kategori_cukai = ArrayHelper::map(RefTaxCategory::find()->all(), 'TC_CATEGORY_CODE', 'TC_CATEGORY_DESC');
        $jenis_KWSP = ArrayHelper::map(RefEpfType::find()->all(), 'ET_CODE', 'ET_DESC');
        $kaedah_kiraan =  ArrayHelper::map(RefSocsoType::find()->all(), 'ST_CODE', 'ST_DESC');
        $jenis_perkeso =  ArrayHelper::map(RefSocsoType::find()->all(), 'ST_CODE', 'ST_DESC');
        $model = new TblStaffSalary();
        $lla = 'none';
        $nd = ' ';
        $lnd = 'none';
        
        if ($model->load(Yii::$app->request->post())) {
            $model->SS_STAFF_ID = $umsper;
            $model->SS_ENTER_BY = Yii::$app->user->identity->getId();
            $model->SS_ENTER_DATE = date('Y-m-d H:i:s');
            $model->SS_CMPY_CODE = UMS;
            $model->SS_BASIC_SALARY = $biodata->getGajiBasic();
            $model->SS_REF_CODE = SS.date('YmdHis');
            $model->SS_UPDATE_BY = Yii::$app->user->identity->getId();
            $model->SS_UPDATE_DATE = date('Y-m-d H:i:s');
            $model->save(false);
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
               
            return $this->redirect(['saraan/rekod-lpg-v2', 'umsper' => $umsper]);
        } 
        
        return $this->renderAjax('tambah-profil-gaji', [
              'biodata'=> $biodata,'model' => $model,'lla'=>$lla, 'umsper' => $umsper, 'nd' => $nd, 'lnd' => $lnd,'lantikan' => $lantikan, 'model1' => $model1,
            'formula_cukai' => $formula_cukai, 'kategori_cukai' => $kategori_cukai, 'jenis_KWSP' => $jenis_KWSP, 'kaedah_kiraan' => $kaedah_kiraan, 'jenis_perkeso' => $jenis_perkeso
        ]);
    }
    
         public function actionDeleteProfilGaji($id) {
        $model = TblStaffSalary::find()->where(['id' => $id ])->one();
        $model->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dipadam']);
        return $this->redirect(['view', 'umsper' => $model->SS_STAFF_ID]);
    }
    
      public function actionLihatProfilGaji($id)
    {
         $detail = TblStaffSalary::find()->where(['id' => $id ])->one();
         return $this->render('lihat-profil-gaji', ['detail' => $detail]);
    
        
    }
    
       public function actionLihatGaji($id)
    {
         $model = TblStaffSalary::find()->where(['id' => $id ])->one();
         $kwsp = \app\models\vhrms\StaffAccount::find()->where(['SA_STAFF_ID' =>  $model->SS_STAFF_ID])->andFilterWhere(['or', ['=', 'SA_ACCT_NAME','KWSP']])->one();
         $kwap = \app\models\vhrms\StaffAccount::find()->where(['SA_STAFF_ID' =>  $model->SS_STAFF_ID])->andFilterWhere(['or', ['=', 'SA_ACCT_NAME','KWAP']])->one();
         $cukai = \app\models\vhrms\StaffAccount::find()->where(['SA_STAFF_ID' => $model->SS_STAFF_ID])->andFilterWhere(['or', ['=', 'SA_ACCT_NAME','LHDN']])->one();
         $akaun = \app\models\vhrms\StaffAccount::find()->where(['SA_STAFF_ID' => $model->SS_STAFF_ID])->andFilterWhere(['or', ['=', 'SA_ACCT_NAME','SALARY']])->one();
        
         return $this->renderAjax('lihat-gaji', ['model' => $model,  'kwsp' => $kwsp, 'kwap' => $kwap, 'cukai' => $cukai, 'akaun'=> $akaun]);
    
        
    }
    
        public function actionKemaskiniProfilGaji($id) {
        $lantikan =  ArrayHelper::map(StatusLantikan::find()->all(), 'ApmtStatusCd', 'ApmtStatusNm');
        $formula_cukai =  ArrayHelper::map(RefTaxFormulaType::find()->all(), 'TFT_FORMULA_TYPE_CODE', 'TFT_DESC');
        $kategori_cukai = ArrayHelper::map(RefTaxCategory::find()->all(), 'TC_CATEGORY_CODE', 'TC_CATEGORY_DESC');
        $jenis_KWSP = ArrayHelper::map(RefEpfType::find()->all(), 'ET_CODE', 'ET_DESC');
        $kaedah_kiraan =  ArrayHelper::map(RefSocsoType::find()->all(), 'ST_CODE', 'ST_DESC');
        $jenis_perkeso =  ArrayHelper::map(RefSocsoType::find()->all(), 'ST_CODE', 'ST_DESC');
        $model =  TblStaffSalary::find()->where(['id' => $id ])->one();
        $biodata= Tblprcobiodata::find()->where(['COOldID' => $model->SS_STAFF_ID])->one();

           if ($model->load(Yii::$app->request->post())) {
            $model->SS_UPDATE_BY = Yii::$app->user->identity->getId();
            $model->SS_UPDATE_DATE = date('Y-m-d H:i:s');
            $model->save();
            
           Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);
               
            return $this->redirect(['view', 'COOldID' => $biodata->COOldID]);
        } 
        
        return $this->renderAjax('kemaskini_profil_gaji', [
                    'model' => $model,'lantikan' => $lantikan, 'formula_cukai' => $formula_cukai, 'kategori_cukai' => $kategori_cukai, 'jenis_KWSP' => $jenis_KWSP
                , 'kaedah_kiraan' => $kaedah_kiraan, 'jenis_perkeso' => $jenis_perkeso, 'biodata' => $biodata
        ]);
        
        }
    
      protected function findModelbyid($id) {
        if (($model = ViewPayroll::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
       protected function findModelbyicno($COOldID) {
        if (($model = ViewPayroll::findAll(['MPH_STAFF_ID' => $COOldID])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
     public function actionSenaraiProfil($ICNO=null,$DeptId=null,$campus_id=null) {
        $dataProvider = new ActiveDataProvider([
            'query' => Tblprcobiodata::find()
                       ->joinWith('department')
                       ->joinWith('jawatan')
                       ->joinWith('kampus')
                       ->where(['<>', 'tblprcobiodata.Status', '6']),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        
        $dataProvider->query->orderBy([
     //       new \yii\db\Expression("Status = 1 ASC"),
            //'id' => SORT_ASC,
            //'ICNO' => SORT_ASC,
        ]); 
        
        if(isset(Yii::$app->request->queryParams['ICNO'])){
        $ICNO? $dataProvider->query->andFilterWhere(['ICNO' => $ICNO]):'';}
       
        if(isset(Yii::$app->request->queryParams['DeptId'])){
        $DeptId? $dataProvider->query->andFilterWhere(['DeptId' => $DeptId]):'';}
        
        if(isset(Yii::$app->request->queryParams['campus_id'])){
        $campus_id? $dataProvider->query->andFilterWhere(['campus_id' => $campus_id]):'';}
   
        return $this->render('senarai-profil', [
                'ICNO' => $ICNO,
                'DeptId' => $DeptId,
                'campus_id' => $campus_id,
                'dataProvider' => $dataProvider,
        ]);
    }
    
    
}
