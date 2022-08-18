<?php

namespace app\commands;

use app\models\Notification;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
// use yii\helpers\VarDumper;

class NotiController extends Controller
{

    public function actionAutoRead()
    {
        $today = date('Y-m-d');

        $month_before = date('m', strtotime($today . ' -1 month'));

        $model = Notification::updateAll(['status'=>1],['status'=> 0, 'MONTH(ntf_dt)'=>$month_before]);

        if($model){
            echo "Done";
        }

        return ExitCode::OK;
            
    }
}
