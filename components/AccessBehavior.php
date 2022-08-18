<?php

namespace app\components;

use yii;
use yii\base\Behavior;
use yii\console\Controller;
use yii\helpers\Url;


class AccessBehavior extends Behavior
{
    
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction'
        ];
    }
    
    public function beforeAction()
    {
        // if (Yii::$app->user->isGuest  &&
        //     Yii::$app->request->url !== Url::to(Yii::$app->user->loginUrl)) {
        //     //Yii::$app->response->redirect('/site/login');
        //     return Yii::$app->response->redirect(Url::to(Yii::$app->user->loginUrl))->send();
        // }
    }


}