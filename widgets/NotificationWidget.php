<?php
namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use app\models\Notification;
use Yii;

class NotificationWidget extends Widget{
    public $noti;
    public $total;
    
    public function init(){
        parent::init();
        
        $icno = Yii::$app->user->getId();
        
        $model = Notification::find()->where(['icno'=>$icno, 'status'=>0])->orderBy(['ntf_dt' => SORT_DESC])->limit(5)->all();
        
        $total_unread = Notification::find()
        ->where(['icno'=>$icno, 'status'=>0])
        ->orderBy(['ntf_dt' => SORT_DESC])
        ->asArray()
        ->count('id');
        
        $this->total = $total_unread;
        
        $this->noti = $model;
        
    }

    public function run(){
//        return Html::encode($this->message);
        return $this->render('notificationWidget', ['noti'=>$this->noti, 'total'=>$this->total]);
    }
}
?>