<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\hronline\TblmpMonitorReminder;
use app\models\hronline\TblmpMonitorReminderSearch;
use app\models\Notification;

class MPAdminController extends \yii\web\Controller
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
                'only' => ['index','view-paspot-permit' ],
                'rules' => [
                    Yii::$app->AccessManager->Allowed(Yii::$app->controller->id)
                    ,
                    [
                        'actions' => ['index','view-paspot-permit' ],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                           $icno = Yii::$app->user->getId() ;
                           if($icno == '940402125181'){
                               return true;
                           }
                           return false;                           
                        }
                    ],
                ],
            ],
        ];
    }
    public function actionIndex(){
       
        $searchModel = new TblmpMonitorReminderSearch();
            
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionNotiInfo($id){
        $model = TblmpMonitorReminder::find()->where(['id'=>$id])->one();

        return $this->renderAjax('notiinfo',[
            'model'=>$model,
        ]);
    }

    public function actionDeleteNoti($id){
        $model = TblmpMonitorReminder::find()->where(['id'=>$id])->one();

        if($model->delete()){
            return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
        }
        
        return $this->renderAjax('notiinfo',[
            'model'=>$model,
        ]);
    }

    public function actionBatchDeletion(){
        $model = new Notification();
        $total = 0;
        if($model->load(Yii::$app->request->post())){
            $title = 'Maklumat Peribadi (' .$model->title. ')';
            $ntf_dt = $model->ntf_dt;
            $total = Notification::find()->where(['LIKE','title',$title])->andWhere(['ntf_dt'=>$ntf_dt])->count();
            // foreach($model as $bd){
            //     $bd->delete();
            // }
        }

        return $this->render('batchdeletion',[
            'model'=>$model,
            'total'=>$total,
        ]);
    }

}
