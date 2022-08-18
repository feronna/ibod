<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;
use app\models\system_core\TblMenuTop;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

class TopMenuWidget extends Widget{
    public $top_menu;
    public $vars;
    
    public function init(){
        parent::init();
        
        //$controller = Yii::$app->controller->id;
        
        //$arry = TblMenuTop::find()->where(['LIKE', 'url', $controller])->andWhere(['parent_id' => null])->orderBy(['order' => SORT_ASC])->all();
        $arry = TblMenuTop::findAll($this->top_menu);
        $test = ArrayHelper::toArray($arry,
                [
                    'app\models\system_core\TblMenuTop' => [
                        'label' => function($tmp) {
                            return '<i class="fa fa-'.$tmp->icon->icon_label.'"></i> '.$tmp->label;
                        },
                        'url' => function($tmp) {
                            return (!empty($tmp->child2)) ? '#' : (array)$tmp->url;
                        },
                        'visible' => function($tmp) {
                            //return (empty($tmp->visible)) ? true : $tt;
                            switch(empty($tmp->visible)) {
                                case true:
                                    return true;
                                case false:
                                    //ob_start();
                                    //eval($tmp->visible.';');
                                    //$tt = ob_get_contents();
                                    //ob_end_flush();
                                    //return $tt;
                                    return $tt = eval('return '.$tmp->visible.';');
                            }
                        },
                        'items' => function($tmp) {
                            $arry = TblMenuTop::find()->where(['parent_id' => $tmp->id, 'status' => 1])->orderBy(['order' => SORT_ASC])->all();
                            $test = ArrayHelper::toArray($arry, [
                                'app\models\system_core\TblMenuTop' => [
                                    'label' => function($tmp) {
                                        return '<i class="fa fa-'.$tmp->icon->icon_label.'"></i> '.$tmp->label;
                                    },
                                    'url' => function($tp) {
                                        return (array)$tp->url;
                                    },
                                    'visible' => function($tmp) {
                                        //return (empty($tmp->visible)) ? true : $tt;
                                        switch(empty($tmp->visible)) {
                                            case true:
                                                return true;
                                            case false:
                                                //ob_start();
                                                //eval($tmp->visible.';');
                                                //$tt = ob_get_contents();
                                                //ob_end_flush();
                                                //return $tt;
                                                return $tt = eval('return '.$tmp->visible.';');
                                        }
                                    },
                                ]
                            ]);
                            return $test;
                        },
                    ]]);
            if(!is_null($this->vars)){
                foreach($this->vars as $i => $tt) {
                    $test[$i]['label'] = $test[$i]['label'].' '.$tt['label'];
                    if(array_key_exists("items", $this->vars[$i])){
                        foreach($this->vars[$i]['items'] as $ii => $ttt){
                            $test[$i]['items'][$ii]['label'] = $test[$i]['items'][$ii]['label'].' '.$ttt['label'];
                        }
                    }
                }
                
                return $this->top_menu = $test;
            }else {
                return $this->top_menu = $test;
            }
    }

    public function run(){
        return $this->render('top-menu', ['tops' => $this->top_menu, 'vars' => $this->vars]);
    }
}
?>