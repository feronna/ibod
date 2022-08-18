<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\mohonjawatan\TblOpenpos;

/**
 * command ni akan run pada setiap hari pada jam 1 pagi;
 * kenapa jam 1 pagi, kerana jam 1 pagi keadaan mula tenang.. suasana begitu asyik sekali..
 * every function akan detect kehadiran day before command ni kena run..
 * Run command ni pakai Windows Task scheduler[weekly-isnin hingga jumaat].
 */
class OpenposController extends Controller {

    /**
     * Ni untuk check yang ada sda time in.. tp teda time out... status incomplete
     * 
     * @return EXITCODE
     */
    public function actionUpdatestatus()
    
    {
        $date = TblOpenpos::findOne(['status' => 1]);
        $todaydate = date('Y-m-d');
        

        if ($todaydate >= ($date->date_end)) {
           $result = TblOpenpos::updateAll(['status'=>0]);
           echo $result;
            return ExitCode::OK;
        }
        
//        $today = date('Y-m-d');
//        $date_before = date('Y-m-d', strtotime($today . ' -1 day'));
//        $result = TblRekod::updateAll(['incomplete' => 1], ['tarikh' => $date_before, 'absent' => 0, 'time_out' => NULL, 'status_out' => NULL]);
//        echo $result;
//        return ExitCode::OK;
    }

}
