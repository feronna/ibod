<?php

namespace app\commands;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Html;
use app\models\memorandum\TblRekod;
use app\models\memorandum\TblMaklumbalasPtj;
use app\models\Notification;
use app\models\memorandum\TblTindakan;

error_reporting(0);
// use kartik\datetime;
// e
// use DateTime;
/**
 * command ni akan run pada setiap hari pada jam 2 pagi;
 * kenapa jam 2 pagi, kerana jam 2 pagi keadaan mula tenang.. suasana begitu asyik sekali..
 * Run command ni pakai Windows Task scheduler setiap hari.
 */
class MemorandumController extends Controller {
    
      public function actionAutoNotifyKj(){
          
        $check = TblMaklumbalasPtj::find()->where(['status_kj' => 0])->all();

          foreach($check as $checks) {   
           
                //----------send noti pemakluman---------//  
                            $ntf = new Notification();
                            $ntf->icno = $checks->kj;
                            $ntf->title = 'e-Memorandum';
                            $ntf->content = "Perakuan maklumbalas memorandum jabatan menunggu tindakan tuan/puan."
                                            ."<a href='/staff/web/memorandum/halaman-kj' class='btn btn-primary'> PAPAR <i class='fa fa-arrow-right'></i></a>'";
                             $ntf->ntf_dt = date('Y-m-d H:i:s');
                             $ntf->save();
                 //----------send noti pemakluman---------//  
      
        
      }
        echo "berjaya"; 
       return ExitCode::OK;

    }
    
     public function actionAutoNotifyPenyelia(){
         
        $tblRekod = TblMaklumbalasPtj::find()->all();
        
 
       $q = TblTindakan::find()->where(['not in' , 'id_rekod' , $tblRekod->id_rekod])->andWhere(['not in', 'id_perkara', $tblRekod->id_perkara])->all();

          foreach($q as $q) {   
           
                //----------send noti pemakluman---------//  
                            $ntf = new Notification();
                            $ntf->icno = $q->penyelia;
                            $ntf->title = 'e-Memorandum';
                            $ntf->content = 'Maklumbalas memorandum menunggu tindakan tuan/puan.'
                                             ."<a href='/staff/web/memorandum/senarai-memorandum-ptj' class='btn btn-primary'> PAPAR <i class='fa fa-arrow-right'></i></a>'";
                             $ntf->ntf_dt = date('Y-m-d H:i:s');
                             $ntf->save();
                 //----------send noti pemakluman---------//  
    
               }
       // echo "berjaya"; 
        echo $q->penyelia;
       return ExitCode::OK;

    }
    
   

}
