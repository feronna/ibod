<?php
namespace app\widgets;

use yii\base\Widget;
use app\models\system_core\TblAnnouncements;

class AnnouncementWidget extends Widget{

    public $model;
    
    public function init(){
        parent::init();
        
//        $icno = Yii::$app->user->getId();
        
//        $model = Notification::find()->where(['icno'=>$icno, 'status'=>0])->orderBy(['ntf_dt' => SORT_DESC])->limit(5)->all();
//        
//        $total_unread = Notification::find()->where(['icno'=>$icno, 'status'=>0])->orderBy(['ntf_dt' => SORT_DESC])->all();
//        
//        $this->total = count($total_unread);
//        
//        $this->noti = $model;

        $date_now = date('Y-m-d');
        
        $model = TblAnnouncements::find()->where(['status'=>1])->andWhere(['>=', 'end_dt',$date_now])->andWhere(['<=', 'start_dt', $date_now])->orderBy(['start_dt'=>SORT_DESC])->all();
        
        $this->model = $model;
        
        
    }

    public function run(){
//        return Html::encode($this->message);
        return $this->render('announcementWidget', ['model'=>$this->model]);
    }
}
?>