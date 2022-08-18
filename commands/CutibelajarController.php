<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use app\models\hronline\Tblprcobiodata;
use app\models\Notification;
use app\models\cbelajar\TblLkk;
use yii\helpers\Html;
use app\models\cbelajar\TblUrusMesyuarat;
error_reporting(0);

/**
 * command ni akan run pada setiap hari pada jam 2 pagi;
 * kenapa jam 2 pagi, kerana jam 2 pagi keadaan mula tenang.. suasana begitu asyik sekali..
 * every function akan detect kehadiran day before command ni kena run..
 * Run command ni pakai Windows Task scheduler setiap hari.
 */
class CutibelajarController extends Controller {

    /**
     * Untuk detect siapa yang akan tamat kontrak selepas 120 hari;
     * 
     * @return EXITCODE;
     * 
     */
//    
//    public function actionHantarLaporan() {
//        $layak = TblBukapermohonan::find()->where(['id' => '5'])->one();
//        $mohon = TblPermohonan::find()->where([])
//        $biodata = Tblprcobiodata::find()->where(['!=','statLantikan','1'])->all();
//        if($layak){
//        foreach ($biodata as $model){
//        $tarikhtamat = date_format(date_create($model->endDateLantik),'Y-m-d');
//        if($model->jawatan->job_category=="2" && $tarikhtamat >= $layak->start_tamatkontrak && $tarikhtamat <= $layak->end_tamatkontrak ){
//         
//            //----------Model Notification ---------//
//                    $ntf = new Notification();
//                    $ntf->icno = $model->ICNO;
//                    $ntf->title = 'Pelantikan Semula Kontrak';
//                    $ntf->content = "Adalah Dimaklumkan bahawa kontrak perkhidmatan tuan/puan akan tamat pada $model->tarikhtamatlantik. Tuan/puan adalah dipelawa untuk mengemukakan permohonan pelantikan semula kontrak <b>DALAM KADAR SEGERA</b>. "
//                            . "Kegagalan tuan/puan berbuat demikian akan dianggap tidak berminat untuk melanjutkan perkhidmatan di UMS.";
//                    $ntf->ntf_dt = date('Y-m-d H:i:s');
//                    $ntf->save();
//                    //--------Model Notification-----------//
//        }
//        }
//        }
//                    //--------Model Notification-----------//
//        return ExitCode::OK;
//    }
//    private function willexpired($icno){  // pengajian will be expired
//
//        $paspot = \app\models\cbelajar\TblPengajian::find()->where(['ICNO'=>$icno])->all();
//        $pdate = null;
//        $notydate = null;
//        $cdate = date("Y-m-d");
//        $will_expired = false;
//        switch (count($paspot)) {
//            case '0':
//                $pdate = null;
//                break;
//            case '1':
//                foreach ($paspot as $p) {
//                    $pdate = $p->tarikh_tamat;
//                }
//                break;
//            
//            default:
//                $date = null;
//                $i = 0;
//                foreach ($paspot as $p) {
//                    $date = $p->tarikh_tamat;
//
//                    if($i == 0 || $pdate < $date){
//                        $pdate = $date;
//                    }
//                    
//                    $i++;
//                }
//                break;
//        }
//        if (!is_null($pdate)) {
//            $notydate = date("Y-m-d", strtotime("-180 days", strtotime($pdate)));
//            if (($cdate == $notydate || $notydate < $cdate) && $pdate > $cdate) {
//                $will_expired = true;
//            }
//        }
//        return [$will_expired, $notydate];
//
//    }

    public function actionAutoStartPengajian() {
        $icno = Yii::$app->user->getId();

        $start = date('Y-m-d');
        $biodata = Tblprcobiodata::find()->where(['Status' => "1"])->all();

        foreach ($biodata as $model) {
            $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['icno' => $model->ICNO, 'status' => 1])->one();

            $biodata = Tblprcobiodata::find()->where(['ICNO' => $model->ICNO])->one();
            $perkhidmatan = new \app\models\hronline\Tblrscoservstatus();

            if ($pengajian) {


                $start_dt = $pengajian->tarikh_mula;
            }
//        $tarikhtamat = date_format(date_create($model->tarikh_tamat),'Y-m-d');
            if ($pengajian) {
                if (in_array($biodata->jawatan->job_category, [1, 2]) && $start == $start_dt) {



                    //----------Model Notification ---------//
                    $perkhidmatan->ICNO = $pengajian->icno;
                    $perkhidmatan->ServStatusStDt = $pengajian->tarikh_mula;
//                     $perkhidmatan->ICNO = $icno;

                    $perkhidmatan->ServStatusCd = 2;
                    $perkhidmatan->ServStatusDtl = 2;
                    $perkhidmatan->save(false);
                    $biodata->Status = 2;
                    $ntf = new Notification();
                    $ntf->icno = $model->ICNO;
                    $ntf->title = 'PengajianLanjutan';
                    $ntf->content = "Adalah Dimaklumkan bahawa pengajian lanjutan tuan/puan akan bermula pada " . $pengajian->tarikhmula;
                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                    $biodata->save(false);
                    $ntf->save();
                    echo $model->ICNO;

                    //--------Model Notification-----------//
                }
            }
        }
        //--------Model Notification-----------//
        return ExitCode::OK;
    }

    function getRealUserIp() {
        switch (true) {
            case (!empty($_SERVER['HTTP_X_REAL_IP'])):
                return $_SERVER['HTTP_X_REAL_IP'];
            case (!empty($_SERVER['HTTP_CLIENT_IP'])):
                return $_SERVER['HTTP_CLIENT_IP'];
            case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])):
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            default:
                return $_SERVER['REMOTE_ADDR'];
        }
    }

    public function actionTamatpengajian() {


        $current_date = date('Y-m-d');
        $final = date('Y-m-d', strtotime('+6 months'));
//        $layak = TblBukapermohonan::find()->where(['start_bolehmohon' => $current_date])->one();
//        $biodata = Tblprcobiodata::find()->where(['!=','statLantikan','1'])->all();        
        $biodata = Tblprcobiodata::find()->where(['Status' => "2"])->all();
//        echo $final;//        $tamat = \app\models\cbelajar\TblPengajian::find()->where()


        foreach ($biodata as $model) {
            $pengajian = \app\models\cbelajar\TblPengajian::find()->where(['icno' => $model->ICNO, 'status' => 1])->one();
            $lanjutan = \app\models\cbelajar\TblLanjutan::find()->where(['icno' => $model->ICNO])->one();

            $biodata = Tblprcobiodata::find()->where(['ICNO' => $model->ICNO])->one();
            if ($lanjutan) {

                $end_date = $lanjutan->lanjutanedt;
            } elseif ($pengajian) {


                $end_date = $pengajian->tarikh_tamat;
            }
//        $tarikhtamat = date_format(date_create($model->tarikh_tamat),'Y-m-d');
            if ($pengajian) {
                if ($biodata->jawatan->job_category == "1" && $final == $end_date) {



                    //----------Model Notification ---------//
                    $ntf = new Notification();
                    $ntf->icno = $model->ICNO;
                    $ntf->title = 'Pelanjutan Tempoh Cuti Belajar';
                    $ntf->content = "Adalah Dimaklumkan bahawa pengajian lanjutan tuan/puan akan tamat pada $pengajian->tarikh_tamat. Tuan/puan adalah dipelawa untuk mengemukakan permohonan pelanjutan tempoh cuti belajar <b>DALAM KADAR SEGERA</b>. "
                            . "Kegagalan tuan/puan berbuat demikian akan dianggap tidak berminat untuk melanjutkan tempoh cuti belajar.";
                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                    $ntf->save();
                    echo $model->ICNO;

                    //--------Model Notification-----------//
                }
            }
        }
        //--------Model Notification-----------//
        return ExitCode::OK;
    }

    public function actionLkp() {


        $current_date = date('Y-m-d');
        $final = date('Y-m-d', strtotime('+6 months'));
//        $layak = TblBukapermohonan::find()->where(['start_bolehmohon' => $current_date])->one();
//        $biodata = Tblprcobiodata::find()->where(['!=','statLantikan','1'])->all();        
        $biodata = Tblprcobiodata::find()->where(['Status' => "2"])->all();
//        echo $final;//        $tamat = \app\models\cbelajar\TblPengajian::find()->where()
//           echo $final;
        foreach ($biodata as $model) {
            $lkk = \app\models\cbelajar\TblLkk::find()->where(['icno' => $model->ICNO])->one();

            $biodata = Tblprcobiodata::find()->where(['ICNO' => $model->ICNO])->one();

//        $tarikhtamat = date_format(date_create($model->tarikh_tamat),'Y-m-d');
            if ($lkk) {
//            echo '-';
                if ($biodata->jawatan->job_category == "1" && \app\models\cbelajar\TblLkk::find()->where([
                            'icno' => $model->ICNO, 'effectivedt' => $final])->exists()) {



                    //----------Model Notification ---------//
                    $ntf = new Notification();
                    $ntf->icno = $model->ICNO;
                    $ntf->title = 'Laporan Kemajuan Pengajian (LKP) ';
                    $ntf->content = "Sila hantar "
                            . "Laporan Kemajuan Pengajian anda $lkk->effectivedt. ";

                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                    $ntf->save();
                    echo $model->ICNO;

                    //--------Model Notification-----------//
                }
            }
        }
        //--------Model Notification-----------//
        return ExitCode::OK;
    }

    public function actionSendPeringatanLkp() {

        $current_date = date('Y-m-d');
        $final = date('Y-m-d', strtotime('+3 months'));
        $biodata = Tblprcobiodata::find()->where(['ICNO' => "950829125446", 'Status' => 1])->all();

        $set_from = ['pengajianlanjutan@ums.edu.my' => 'HRONLINE v4.0 - Sistem Pengajian Lanjutan '];
        $subject = 'PERINGATAN: PENGHANTARAN LAPORAN KEMAJUAN PENGAJIAN (LKP)';

            $lkk = \app\models\cbelajar\TblLkk::find()->where(['icno' => 950829125446])->andWhere(['effectivedt' => $final])->one();


//        $layak = TblBukapermohonan::find()->where(['start_bolehmohon' => $current_date])->one();
//        $biodata = Tblprcobiodata::find()->where(['!=','statLantikan','1'])->all();        
//        $biodata = Tblprcobiodata::find()->where(['Status' => "2"])->all();
//        echo $final;//        $tamat = \app\models\cbelajar\TblPengajian::find()->where()
//           echo $final;
//        foreach ($biodata as $model){
//         $lkk = \app\models\cbelajar\TblLkk::find()->where(['icno'=>$model->ICNO,'effectivedt'=>$final])->one();
//        
//        $biodata = Tblprcobiodata::find()->where(['ICNO' => $model->ICNO])->one();
//         if($lkk)
//            
//        {
//            echo '-';
//            
//              
//
//                              
//                $email = $model['COEmail'];
//                $name = $model['CONm'];
//             
//                  $set_to = [$email => $name];
//                    Yii::$app->mailer->compose()
//                    ->setFrom('pengajianlanjut@ums.edu.my')
//                    ->setTo($email)
//->setCc(['norfazleenawana@ums.edu.my'])
//->setSubject($subject)
//->send();
//             
//
//               if ($email) {
//                    $set_to = [$email => $name];                   
//                    Yii::$app->mailer->compose('peringatan_lkk', ['model' => $model,'lkk'=>$lkk])
//                            ->setFrom('pengajianlanjut@ums.edu.my')
//                           ->setTo($email)
//                            ->setCc(['norfazleenawana@ums.edu.my'])
//                           ->setSubject($subject)
//                           ->send();
//               }
//        } 
//        }
//        }
//        foreach ($lkk as $bio) {
//            
//            
//            if (\app\models\cbelajar\TblLkk::totalPendingKetidakpatuhan($bio['ICNO'], TRUE) != 0) {
//             
//                $model = tbl::totalPendingKetidakpatuhan($bio['ICNO'], FALSE, TRUE);
//
//                $email = $bio['COEmail'];
//                $name = $bio['CONm'];
//
//                if ($email) {
//                    $set_to = [$email => $name];
//                    Yii::$app->mailer->compose('peringatan_lkk',
//                      ['model' => $model])
//                        ->setFrom($set_from)
//                        ->setTo($set_to)
//                        ->setSubject($subject)
//                        ->send();
//                }
//            }
//        }
        foreach ($biodata as $bio) {
//            if (TblRekod::totalPendingKetidakpatuhan($bio['ICNO'], TRUE) != 0) {
//                $total = TblRekod::totalPendingKetidakpatuhan($bio['ICNO'], TRUE);
//                $model = TblRekod::totalPendingKetidakpatuhan($bio['ICNO'], FALSE, TRUE);

            $email = $bio['COEmail'];
            $name = $bio['CONm'];

            if ($email) {
                $set_to = [$email => $name];
                Yii::$app->mailer3->compose('peringatan_lkk',['lkk'=>$lkk])
                        ->setFrom($set_from)
                        ->setTo($set_to)
                        ->setSubject($subject)
                        ->send();
            }
        }
        //   }
//        }
//                    $set_to = ['norfazleenawana@ums.edu.my'];
//                    Yii::$app->mailer->compose('peringatan_lkk',
//                      ['model' => $model])
//                        ->setFrom('cuti.hronline@ums.edu.my')
//                        ->setTo('norfazleenawana@ums.edu.my')
//                        ->setSubject($subject)
//                        ->send();

        return ExitCode::OK;
    }

    public function actionAutoPeringatanLkp() {

        $current_date = date('Y-m-d');
        $final = date('Y-m-d', strtotime('+3 days'));

        $set_from = ['pengajianlanjutan@ums.edu.my' => 'HRONLINE v4.0 - Sistem Pengajian Lanjutan '];
        $subject = 'PERINGATAN MESRA: PENGHANTARAN LAPORAN KEMAJUAN PENGAJIAN (LKP)';

//        $biodata = Tblprcobiodata::find()->where(['ICNO' => 890708125472])->all();
        $biodata = Tblprcobiodata::find()->where(['Status' => '2'])->all();

         
         foreach ($biodata as $model) {
            $final = date('Y-m-d', strtotime('+3 days'));
            $lkk = \app\models\cbelajar\TblLkk::find()->where(['icno' => $model->ICNO,'agree'=>2])->andWhere(['effectivedt' => $final])->one();
           
            
            if ($lkk) {
                if ($model->jawatan->job_category == "1") {
                    //---- Email Notification ----//
                    $email = $model['COEmail'];
                    $name = $model['CONm'];

                    if ($email) {
                        $set_to = [$email => $name];
                        Yii::$app->mailer3->compose('peringatan_lkp_hari', ['lkk' => $lkk])
                                ->setFrom($set_from)
                                ->setTo($set_to)
                                ->setSubject($subject)
                                ->setCc(['norfazleenawana@ums.edu.my','anizah@ums.edu.my'])

                                ->send();
                    }
                }
                echo $model->ICNO . ' SEKARANG';
            }else{
                
                echo $model->ICNO . 'TIADA';
            }
        }
      foreach ($biodata as $model) {
            $final = date('Y-m-d', strtotime('+3 months'));
            $lkk = \app\models\cbelajar\TblLkk::find()->where(['icno' => $model->ICNO])->andWhere(['effectivedt' => $final])->one();
           
            
            if ($lkk) {
                if ($model->jawatan->job_category == "1") {
                    //---- Email Notification ----//
                    $email = $model['COEmail'];
                    $name = $model['CONm'];

                    if ($email) {
                        $set_to = [$email => $name];
                        Yii::$app->mailer3->compose('peringatan_lkp_bulans', ['lkk' => $lkk])
                                ->setFrom($set_from)
                                ->setTo($set_to)
                                ->setSubject($subject)
                                ->setCc(['norfazleenawana@ums.edu.my','anizah@ums.edu.my'])

                                ->send();
                    }
                }
                echo $model->ICNO . ' SEKARANG';
            }else{
                
                echo $model->ICNO . 'TIADA';
            }
        }
        
         foreach ($biodata as $model) {
            $final = date('Y-m-d', strtotime('+6 months'));
            $lkk = \app\models\cbelajar\TblLkk::find()->where(['icno' => $model->ICNO])->andWhere(['effectivedt' => $final])->one();
           
            
            if ($lkk) {
                if ($model->jawatan->job_category == "1") {
                    //---- Email Notification ----//
                    $email = $model['COEmail'];
                    $name = $model['CONm'];

                    if ($email) {
                        $set_to = [$email => $name];
                        Yii::$app->mailer3->compose('peringatan_lkp_enam', ['lkk' => $lkk])
                                ->setFrom($set_from)
                                ->setTo($set_to)
                                ->setSubject($subject)
                                ->setCc(['norfazleenawana@ums.edu.my','anizah@ums.edu.my'])

                                ->send();
                    }
                }
                echo $model->ICNO . ' SEKARANG';
            }else{
                
                echo $model->ICNO . 'TIADA';
            }
        }

        return ExitCode::OK;
    }

//    public function actionAutoPeringatanLkp()
//    {
//
//        $current_date =date('Y-m-d');
//        $final=  date('Y-m-d', strtotime('+6 months'));
////        $biodata = Tblprcobiodata::find()->where(['Status' => 1])->all();
//        $set_from = ['pengajianlanjutan@ums.edu.my' => 'HRONLINE v4.0 - Sistem Pengajian Lanjutan '];
//        $subject = 'PERINGATAN: PENGHANTARAN LAPORAN KEMAJUAN PENGAJIAN (LKP)';
//            //        $icno=Yii::$app->user->getId();
//
//        $biodata = Tblprcobiodata::find()->where(['ICNO'=>950829125446])->one();
//        $lkk = \app\models\cbelajar\TblLkk::find()->where(['icno'=>$biodata->ICNO])->andWhere(['>=','effectivedt',$current_date])
//        ->orderBy(['effectivedt'=>SORT_ASC])->one();
//
//        $set_to = [$biodata->COEmail => $biodata->CONm];
//        Yii::$app->mailer3->compose('peringatan_lkk', ['lkk'=>$lkk])
//                ->setFrom($set_from)
//                ->setTo($set_to)
//                ->setSubject($subject)
//                ->send();
//        return ExitCode::OK;            
//        
//        
//
////        foreach ($biodata as $model){
////         $lkk = \app\models\cbelajar\TblLkk::find()->where(['icno'=>$model->ICNO])->one();
////        
////        $biodata = Tblprcobiodata::find()->where(['ICNO' => $model->ICNO])->one();
////     
//////        $tarikhtamat = date_format(date_create($model->tarikh_tamat),'Y-m-d');
////        if($lkk)
////            
////        {
//////            echo '-';
////        if($biodata->jawatan->job_category=="1" && \app\models\cbelajar\TblLkk::find()->where([
////            'icno'=>$model->ICNO, 'effectivedt'=>$final])->exists()){
////            
////            
////       //---- Email Notification ----//
////        $email = $biodata['COEmail'];
////        $name = $biodata['CONm'];
////
////        if ($email) 
////            {
////                    $set_to = [$email => $name];
////                    Yii::$app->mailer2->compose('peringatan_lkk')
////                        ->setFrom($set_from)
////                        ->setTo($set_to)
////                        ->setSubject($subject)
////                        ->send();
////                }
////
////        }
////        }
////        
////        }
//      
//
//                
//        return ExitCode::OK;
//    }
    
    public function actionAutoBukaTutupPermohonan(){
        $model = TblUrusMesyuarat::find()->where(['status'=>1])->all();
        $today = date('Y-m-d');
        foreach ($model as $model) {
            if($model->tarikh_tutup < $today){
                $model->status = 0;
                $model->save();
            }
        }
        
        $model = TblUrusMesyuarat::find()->where(['status'=>0])->all();
        $today = date('Y-m-d');
        foreach ($model as $model) {
            if($model->tarikh_buka <= $today && $model->tarikh_tutup >= $today){
                $model->status = 1;
                $model->save();
            }
        }
        
        return ExitCode::OK;
    }
}
