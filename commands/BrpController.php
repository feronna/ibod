<?php

namespace app\commands;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use app\models\hronline\Tblprcobiodata;
// use app\models\Notification;
//use app\controllers\BrpController;
use yii\helpers\Html;
use app\models\gaji\TblStaffRoc;
use app\models\gaji\TblStaffRocBatchSmbu;
use app\models\brp\Tblrscobrp;
error_reporting(0);
// use kartik\datetime;
// e
// use DateTime;
/**
 * command ni akan run pada setiap hari pada jam 2 pagi;
 * kenapa jam 2 pagi, kerana jam 2 pagi keadaan mula tenang.. suasana begitu asyik sekali..
 * every function akan detect prorate gaji dari smbu before command ni kena run..
 * Run command ni pakai Windows Task scheduler setiap hari.
 */
class BrpController extends Controller {
    
      public function actionAutoAddRekodLpg(){

       $bio = Tblprcobiodata::find()->joinWith('jawatan')->where(['Status' => 1])->andWhere(['statLantikan'=> 1])->andWhere(['job_category'=>2])->all();
       foreach ($bio as $p) {
            $COOldID[] = $p->COOldID;
        }
        
        $check = TblStaffRocBatchSmbu::find()
                 ->where(['srb_status' => 'APPROVE'])
              //  ->andWhere(['srb_staff_id' => '141117-02346'])
                ->andWhere(['in', 'srb_staff_id', $COOldID])
                ->all();

       foreach($check as $checks) {   

       if (!Tblrscobrp::find()->where(['t_lpg_id' => $checks->srb_batch_code])->exists()) {         
    //     $pencen = \app\models\hronline\Tblrscopsnstatus::find()->where(['ICNO' => $checks->biodataSendiri->ICNO])->andWhere(['PsnStatusCd' => 1])->orderBy(['PsnStatusStDt' => SORT_ASC])->one();
      //   $brp = Tblrscobrp::find()->where(['icno' => $checks->biodataSendiri->ICNO])->one();

                    $models = new Tblrscobrp(); 
                    $models->sah = '1';
                    $models->sah_by = 'SYSADMIN';

                    if(\Yii::$app->formatter->asDate($checks->staffRoc3->SR_APPROVE_DATE, 'yyyy-MM-dd')->exists()){
                         $models->sah_date =  $checks->staffRoc3->SR_APPROVE_DATE;
                    }else{
                        $models->sah_date =  NULL;
                    }
                
                    $models->icno =  $checks->biodataSendiri->ICNO;
                    $models->status = 1;
                    $models->status_update_by = 'SYSADMIN';
                    $models->status_date = date('Y-m-d H:i:s');
                    $models->brpCd = "LPG".($checks->srb_change_reason);
                    $models->data_source = "LPG";
                    $models->remark = $checks->srb_remarks;
                    $models->t_lpg_id = $checks->srb_batch_code;
                    $models->jawatan_id = $checks->biodataTerbaru->kakitangan->gredJawatan;
                   
                     if($checks->srb_enter_date != null){
                 
                    $models->tarikh_mulai = \Yii::$app->formatter->asDate($checks->srb_enter_date, 'yyyy-MM-dd');
                    $models->insert_date = $checks->srb_enter_date;
                    $models->tarikh_surat = \Yii::$app->formatter->asDate($checks->srb_enter_date, 'yyyy-MM-dd');
                    
                    echo $checks->srb_enter_date;
                    }  
                    else if($checks->srb_approve_date != null){
                         $models->tarikh_lulus = \Yii::$app->formatter->asDate($checks->srb_approve_date, 'yyyy-MM-dd'); 
                    }
                    else{
                    $models->tarikh_mulai = NULL;
                    $models->tarikh_lulus = NULL;
                    $models->insert_date = NULL;
                    $models->tarikh_surat = NULL;
                    }
//                    if($pencen->PsnStatusCd == 1){
//                    $models->isPencen = 1;
//                    } else{
//                    $models->isPencen = 0; 
//                    }
                
                    $models->save(false); 
                    
                } 
                
        
      }
        echo "berjaya"; 
       return ExitCode::OK;

    }
    
   

}
