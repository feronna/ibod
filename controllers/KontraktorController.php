<?php

namespace app\controllers;

use Yii;
use app\models\Kontraktor\Kontraktor;
use app\models\Kontraktor\KontraktorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Notification; 
use app\models\esticker\TblAccess; 
use app\models\esticker\SenaraiKontraktorSearch;
use app\models\esticker\TblStickerKontraktor;
use app\models\esticker\TblKontraktor;
use app\models\Kontraktor\SyarikatKontraktor;
use app\models\Kontraktor\SyarikatKontraktorSearch;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;

/**
 * KontraktorController implements the CRUD actions for Kontraktor model.
 */
class KontraktorController extends Controller
{
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
                'only' => [
                    //kontraktor
                    'tambah-kontraktor','status-syarikat', 
                ],
                'rules' => [
                      
                    [//kontraktor
                        'actions' => ['tambah-kontraktor','status-syarikat'],
                        'allow' => true,
                        'matchCallback' => function () {
                    $tmp = TblAccess::findOne(['ICNO' => Yii::$app->user->getId(), 'access' => [12]]);
                    return (is_null($tmp)) ? false : true;
                }
                    ],
                        
                ],
            ],
        ];
    } 
    public function actionIndex()
    {
        $searchModel = new KontraktorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    } 
     
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ICNO]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    } 
    
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
 
    protected function findModel($id)
    {
        if (($model = Kontraktor::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
     public function notification($title, $content, $icno = null)
    {
        if($icno == null){
            //default user login id
            $icno = Yii::$app->user->getId();  
        }
        $ntf = new Notification();
        $ntf->icno = $icno;  
        $ntf->title = $title;
        $ntf->content = $content;
        $ntf->ntf_dt = date('Y-m-d H:i:s');
        $ntf->save();
        return true;
    }
    
    public function actionStatusSyarikat() {
      
        $searchModel = new SenaraiKontraktorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('status_syarikat', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                 
        ]);
    }
    
    public function actionPerkhidmatanSyarikat($id) {
        $model = new SyarikatKontraktor();
        $record = TblKontraktor::findOne(['apsu_suppid' => $id]);
        $icno = Yii::$app->user->getId();    


        $searchModel = new SenaraiKontraktorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

         if ($model->load(Yii::$app->request->post())) {  
             
            $check = SyarikatKontraktor::find()->where(['apsu_suppid' => $id])->one();
            if($check){
                     Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Jenis Perkhidmatan telah diwujudkan.']);
                     return $this->redirect(['kontraktor/status-syarikat']);
                }

               $model->apsu_suppid =  $record->apsu_suppid;
               $model->name = $record->apsu_lname; 
               $model->updated_by  = $icno;
               $model->updated_at = date('Y-m-d H:i:s');
               $model->isActive = 1;
               
               $model->save(false);  
               Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar!']);
               return $this->redirect(['kontraktor/status-syarikat']);
           
        } 
        return $this->render('form_perkhidmatan_syarikat', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'record' => $record,
                    'model' => $model,

        ]);
    }
    
     public function actionServiceKontraktor() {
        $model = new SyarikatKontraktor();  
        $searchModel = new SyarikatKontraktorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('service_kontraktor', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model, 
        ]);
    }
    
     public function actionCarianKontraktor() {
        $model = new TblStickerKontraktor(); 
        
        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['senarai-kontraktor', 'id' => $model->id_kontraktor]);
        }
 
        return $this->render('form_carian_kontraktor', [
                    'model' => $model, 
                    'title' => 'Carian Kontraktor',
                    
        ]);
    }
    
    public function actionSenaraiKontraktor($id) {
        $model = new TblStickerKontraktor();
        $record = TblKontraktor::findOne(['apsu_suppid' => $id]);

        $query = Kontraktor::find()->where(['id_kontraktor' => $id]);   
        
        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['senarai-kontraktor', 'id' => $model->id_kontraktor]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('form_senarai_kontraktor', [
                    'model' => $model,
                    'record' => $record,
                    'dataProvider' => $dataProvider,
                    'title' => 'Carian Kontraktor',
        ]);
    }
    
    public function actionTambahPekerja() { 
        $model = new Kontraktor(); //change to save data to new table, table utils_tbl_pekerja_kontraktor
        $icno = Yii::$app->user->getId();    

                
        if ($model->load(Yii::$app->request->post())) {
            $exist = Kontraktor::findOne(['ICNO' => $model->ICNO]);
            if (empty($exist)) { 
                $this->simpanPekerja($model);
                $model->created_at = date('Y-m-d H:i:s');
                $model->created_by = $icno;
                $model->Status = 1;
                
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah.']);
                return $this->redirect(['tambah-pekerja']);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'No. KP telah didaftarkan.']);
                return $this->redirect(['tambah-pekerja']);
            }
//            $model->save(false);
        }

        return $this->render('form_tambah_pekerja', [
                    'model' => $model,
                    'title' => 'Tambah Pekerja',
        ]);
    }
    
     public function actionPerincianKontraktor($apsu_suppid) {
        $model = new SyarikatKontraktor();
        $record = SyarikatKontraktor::findOne(['apsu_suppid' => $apsu_suppid]);
        
        $query = Kontraktor::find()->where(['id_kontraktor' => $apsu_suppid]);

        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['senarai-kontraktor', 'id' => $model->id_kontraktor]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('view_detail_kontraktor', [
                    'model' => $model,
                    'record' => $record,
                    'title' => 'Carian Kontraktor',
                    'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionPerincianPekerja($id) {
        $model = new SyarikatKontraktor();
        $record = Kontraktor::findOne(['id' => $id]); 
         

        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['senarai-kontraktor', 'id' => $model->id_kontraktor]);
        }
        
        return $this->render('view_detail_pekerja', [
                    'model' => $model,
                    'record' => $record,
                    'title' => 'Carian Kontraktor', 
        ]);
    }
    
    public function simpanPekerja($model) {

        $model->CONm = strtoupper($model->CONm);
        if (empty($model->filename_vaksin_pm)) {
            $model->filename_vaksin_pm = UploadedFile::getInstance($model, 'kt_vaksin_pm');
            if ($model->filename_vaksin_pm) {
                $res = Yii::$app->FileManager->UploadFile($model->filename_vaksin_pm->name, $model->filename_vaksin_pm->tempName, '01', 'kontraktor_vaksin_pm');
                if ($res->status == true) {
                    $model->filename_vaksin_pm = $res->file_name_hashcode;
                }
            }
        }
        if (empty($model->filename_sijil_pm)) {
            $model->filename_sijil_pm = UploadedFile::getInstance($model, 'kt_sijil_pm');
            if ($model->filename_sijil_pm) {
                $res = Yii::$app->FileManager->UploadFile($model->filename_sijil_pm->name, $model->filename_sijil_pm->tempName, '01', 'kontraktor_sijil_pm');
                if ($res->status == true) {
                    $model->filename_sijil_pm = $res->file_name_hashcode;
                }
            }
        }
        if (empty($model->filename_kad_cidb)) {
            $model->filename_kad_cidb = UploadedFile::getInstance($model, 'kt_kad_cidb');
            if ($model->filename_kad_cidb) {
                $res = Yii::$app->FileManager->UploadFile($model->filename_kad_cidb->name, $model->filename_kad_cidb->tempName, '01', 'kontraktor_kad_cidb');
                if ($res->status == true) {
                    $model->filename_kad_cidb = $res->file_name_hashcode;
                }
            }
        }

        $model->save(false);
    }
}
