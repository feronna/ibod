<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\hronline\Tblprcobiodata;
use app\models\Notification;
use app\models\kontrak\TblBukapermohonan;
use yii\helpers\Html;

/**
 * command ni akan run pada setiap hari pada jam 2 pagi;
 * kenapa jam 2 pagi, kerana jam 2 pagi keadaan mula tenang.. suasana begitu asyik sekali..
 * every function akan detect kehadiran day before command ni kena run..
 * Run command ni pakai Windows Task scheduler setiap hari.
 */
class CvController extends Controller {

    /**
     * Untuk detect siapa yang akan tamat kontrak selepas 120 hari;
     * 
     * @return EXITCODE;
     * 
     */
    
    public function actionLayakmohon() {
        $layak = TblBukapermohonan::find()->where(['id' => '5'])->one();
        $biodata = Tblprcobiodata::find()->where(['!=','statLantikan','1'])->all();
        if($layak){
        foreach ($biodata as $model){
        $tarikhtamat = date_format(date_create($model->endDateLantik),'Y-m-d');
        if($model->jawatan->job_category=="2" && $tarikhtamat >= $layak->start_tamatkontrak && $tarikhtamat <= $layak->end_tamatkontrak ){
         
            //----------Model Notification ---------//
                    $ntf = new Notification();
                    $ntf->icno = $model->ICNO;
                    $ntf->title = 'Pelantikan Semula Kontrak';
                    $ntf->content = "Adalah Dimaklumkan bahawa kontrak perkhidmatan tuan/puan akan tamat pada $model->tarikhtamatlantik. Tuan/puan adalah dipelawa untuk mengemukakan permohonan pelantikan semula kontrak <b>DALAM KADAR SEGERA</b>. "
                            . "Kegagalan tuan/puan berbuat demikian akan dianggap tidak berminat untuk melanjutkan perkhidmatan di UMS.";
                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                    $ntf->save();
                    //--------Model Notification-----------//
        }
        }
        }
                    //--------Model Notification-----------//
        return ExitCode::OK;
    }
    
    public function actionTamatkontrak() {
        $current_date =date('Y-m-d');
        $layak = TblBukapermohonan::find()->where(['start_bolehmohon' => $current_date])->one();
        $biodata = Tblprcobiodata::find()->where(['!=','statLantikan','1'])->all();
        if($layak){
        foreach ($biodata as $model){
        $tarikhtamat = date_format(date_create($model->endDateLantik),'Y-m-d');
        if($model->jawatan->job_category=="2" && $tarikhtamat >= $layak->start_tamatkontrak && $tarikhtamat <= $layak->end_tamatkontrak ){
       
            //----------Model Notification ---------//
                    $ntf = new Notification();
                    $ntf->icno = $model->ICNO;
                    $ntf->title = 'Pelantikan Semula Kontrak';
                    $ntf->content = "Adalah Dimaklumkan bahawa kontrak perkhidmatan tuan/puan akan tamat pada $model->tarikhtamatlantik. Tuan/puan adalah dipelawa untuk mengemukakan permohonan pelantikan semula kontrak <b>DALAM KADAR SEGERA</b>. "
                            . "Kegagalan tuan/puan berbuat demikian akan dianggap tidak berminat untuk melanjutkan perkhidmatan di UMS.";
                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                    $ntf->save();
                    //--------Model Notification-----------//
        }
        }
        }
                    //--------Model Notification-----------//
        return ExitCode::OK;
    }

}
