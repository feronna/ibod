<?php

namespace app\controllers;

use app\models\hronline\Tblprcobiodata;
use Yii;
use app\models\myidp\KursusJemputan;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
class CalendarController extends \yii\web\Controller
{
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
                    'logout' => ['post'],
                    'remove-staff' => ['post'],
                ],
            ],
        ];
    }
 
    public function actionIdp() {
        $model = Tblprcobiodata::find()->where(['ICNO' => Yii::$app->user->getId()])->one();
        $events = array();
        $data = \app\models\myidp\SiriLatihan::find()->joinWith('sasaran8')->where(['gredJawatanID' => $model->jawatan->id, 'tahap' => $model->tahapKhidmat])
                ->andWhere(['<>', 'statusSiriLatihan', 'INACTIVE']);
        
        $model->campus_id != 1? :$data->andWhere(['kampusID' => 1]);
        
        $model->jawatan->job_category == 2? $data->andWhere(['kategoriKursusID'=> [4,5,6,7]]):$data->andWhere(['kategoriKursusID'=> [3,4,1,7]]);
        
        $dataj = KursusJemputan::find()
                ->joinWith('siriKursus.sasaran3')
                ->where(['deptID' => $model->DeptId, 'jobCategory' => NULL])
                ->orWhere(['deptID' => NULL, 'jobCategory' => $model->jawatan->job_category])
                ->orWhere(['jobCategory' => $model->jawatan->job_category, 'deptID' => $model->DeptId])->all();
        
        foreach($data->all() as $d){
        $Event = new \yii2fullcalendar\models\Event();
        if(\app\models\myidp\PermohonanLatihan::find()->where(['staffID' => $model->ICNO, 'siriLatihanID' => $d->siriLatihanID])->exists()){
            $Event->backgroundColor = 'green';
        }
        $Event->id = $d->siriLatihanID;
        $Event->title = $d->sasaran3->tajukLatihan."\n Siri ".$d->siri;
        $Event->start = $d->tarikhMula;
        $events[] = $Event;
        }
        
        foreach($dataj as $d){
        $Event = new \yii2fullcalendar\models\Event();
        $Event->id = $d->siriLatihanID;
        $Event->title = $d->siriKursus->sasaran3->tajukLatihan."\n Siri ".$d->siriKursus->siri;
        $Event->start = $d->siriKursus->tarikhMula;
        $events[] = $Event;
        }
        
        return $this->render('idp', ['events' => $events]);
    }
}
