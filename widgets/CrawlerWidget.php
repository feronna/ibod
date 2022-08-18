<?php
namespace app\widgets;

use yii\base\Widget;
use app\models\system_core\TblAnnouncements;

class CrawlerWidget extends Widget{

    public $model;
    
    public function init(){
        parent::init();
        
        $date = date("Y-m-d");
        
        $model = TblAnnouncements::find()->where(['status'=>1, 'crawler'=>1])
                ->andFilterWhere(['<=', 'start_dt',$date])
                ->andFilterWhere(['>=', 'end_dt',$date])
                ->orderBy(['start_dt'=>SORT_DESC])->all();
        
        $this->model = $model;
        
    }

    public function run(){
//        return Html::encode($this->message);
        return $this->render('crawler', ['model'=>$this->model]);
    }
}
?>