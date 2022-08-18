<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use app\models\keselamatan\TblRekod;
use app\models\hronline\Tblprcobiodata;
//use app\models\kehadiran\TblWp;
use app\models\keselamatan\TblWarnaKad;
use app\models\Notification;
use yii\swiftmailer;
use app\models\keselamatan\TblShiftKeselamatan;
use app\models\keselamatan\TblReports;
use app\models\keselamatan\TblRekodOt;
use app\models\keselamatan\TblRekodLmt;
use app\models\keselamatan\TblOt;
use app\models\keselamatan\TblRollcall;
use app\models\keselamatan\TblStaffKeselamatan;
use DateTime;
use yii\helpers\Html;;

/**
 * command ni akan run pada setiap hari pada jam 1 pagi;
 * kenapa jam 1 pagi, kerana jam 1 pagi keadaan mula tenang.. suasana begitu asyik sekali..
 * every function akan detect kehadiran day before command ni kena run..
 * Run command ni pakai Windows Task scheduler[weekly-isnin hingga jumaat].
 */
class KeselamatanController extends Controller
{

    /**
     * Untuk detect siapa yang tiada rekod langsung[no time in/out] pada hari sebelum console ni kena run;
     * 
     * @return EXITCODE;
     * 
     */
    //send reminder to do after 3 days no action taken
    public function actionSendReminder()
    {

        $today = date('Y-m-d');
        $i = date('Y-m-d', strtotime($today . ' -3 day'));

        $model = TblRollcall::find()->select('date,status,do_icno')->distinct()->where(['=', 'date', $i])->andWhere(['IN', 'status', ['SIMPAN']])->all();
        $model1 = TblRollcall::find()->select('date,status,anggota_icno')->distinct()->where(['=', 'date', $i])->andWhere(['IN', 'status', ['STS']])->all();

        if ($model) {
            foreach ($model as $v) {
                $ntf = new Notification();
                $ntf->icno = $v->do_icno;
                $ntf->title = 'Keselamatan';
                $ntf->content = "Sila Kemaskini Tindakan STS yang Masih dalam Status SIMPAN pada $v->date.";
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
            }
        }

        if ($model1) {
            foreach ($model1 as $r) {
                $ntf = new Notification();
                $ntf->icno = $r->anggota_icno;
                $ntf->title = 'Keselamatan';
                $ntf->content = "Sila buat catatan / Alasan Untuk STS yang Dikeluarkan Kepada anda pada $r->date";
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
            }
        }
        echo count($model);
        echo '/';
        echo count($model1);

        return ExitCode::OK;
    }
    public function actionCheckAbsent()
    {
        $biodata = TblStaffKeselamatan::find()
            ->where(['isActive' => 1])->andWhere(['isExcluded' => 0])->all();
        // ->andWhere(['NOT IN', 'staff_icno', ['790608125733', '851003125657', '860613496249', '780315125669', '760108125721', '770522125195', '710415125777', '720406125643'
        // ,'811126125749','710116125435', '661111125657', '770422125825', '840904126143', '950426125329', '920622155026', '830714126071']])


        $bil = 0;
        $year = date('Y');
        $month = date('m');

        $today = date('Y-m-d');
        $t = date('d');

        $i = date('d', strtotime($today . ' -1 day'));


        foreach ($biodata as $bio) {
            for ($a = 1; $a < $t; $a++) {

                $day_before = date('l', strtotime($today . ' -' . $a . ' day'));
                $d = date('d', strtotime($today . ' -' . $a . ' day'));

                $date_before = $year . '-' . $month . '-' . $d;
                $exist = TblRekod::findOne(['icno' => $bio->staff_icno, 'tarikh' => $date_before]);
                // var_dump($exist->tarikh);die;
                if (!$exist) {
                    //check klu tidak perlu absent
                    $absent = TblRekod::checkAbsent($bio->staff_icno, $date_before);
                    if ($absent === FALSE) {
                        $model = new TblRekod();

                        $model->icno = $bio->staff_icno;
                        $model->tarikh = $date_before;
                        $model->day = $day_before; // output: current day.
                        $model->absent = '1';
                        $model->wp_id = (TblShiftKeselamatan::lastwpcheck($bio->staff_icno, $date_before) == '') ? 1 : TblShiftKeselamatan::lastwpcheck($bio->staff_icno, $date_before);
                        $model->save();

                        $bil++;

                        //                    $btn = Html::a('disini', ['/kehadiran/remark', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']);
                        //----------Model Notification ---------//
                        $ntf = new Notification();
                        $ntf->icno = $bio->staff_icno;
                        $ntf->title = 'Kehadiran';
                        $ntf->content = "Anda Tidak Hadir / Absent pada $date_before ($day_before). Sila buat catatan / Alasan";
                        $ntf->ntf_dt = date('Y-m-d H:i:s');
                        $ntf->save();
                        //--------Model Notification-----------//
                    }
                }
            }
        }


        echo 'success';

        return ExitCode::OK;
    }
    public function actionCheckAbsentOt()
    {
        $biodata = TblStaffKeselamatan::find()
            ->where(['isActive' => 1])
            ->andWhere(['NOT IN', 'staff_icno', [
                '790608125733', '851003125657', '860613496249', '780315125669', '760108125721', '770522125195', '710415125777', '720406125643', '811126125749', '710116125435', '661111125657', '770422125825', '840904126143', '950426125329', '920622155026', '830714126071'
            ]])
            ->all();

        $bil = 0;
        $year = date('Y');
        $month = date('m');

        $today = date('Y-m-d');
        $t = date('d');

        $i = date('d', strtotime($today . ' -1 day'));

        // echo $day_before;die;


        foreach ($biodata as $bio) {

            for ($a = 1; $a < $t; $a++) {

                $day_before = date('l', strtotime($today . ' -' . $a . ' day'));
                $d = date('d', strtotime($today . ' -' . $a . ' day'));

                $date_before = $year . '-' . $month . '-' . $d;
                // echo  $date_before;die;
                $exist = TblRekodOt::findOne(['icno' => $bio->staff_icno, 'tarikh' => $date_before]);

                if (!$exist) {
                    //check klu tidak perlu absent
                    $absent = TblRekodOt::checkAbsent($bio->staff_icno, $date_before);
                    if ($absent === FALSE) {
                        $model = new TblRekodOt();

                        $model->icno = $bio->staff_icno;
                        $model->tarikh = $date_before;
                        $model->day = $day_before; // output: current day.
                        $model->absent = '1';
                        $model->wp_id = (TblOt::lastotcheck($bio->staff_icno, $date_before) == '') ? 1 : TblOt::lastotcheck($bio->staff_icno, $date_before);
                        $model->save();

                        $bil++;

                        //                    $btn = Html::a('disini', ['/kehadiran/remark', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']);
                        //----------Model Notification ---------//
                        $ntf = new Notification();
                        $ntf->icno = $bio->staff_icno;
                        $ntf->title = 'Kehadiran';
                        $ntf->content = "Anda Tidak Hadir / Absent pada $date_before ($day_before). Sila buat catatan / Alasan";
                        $ntf->ntf_dt = date('Y-m-d H:i:s');
                        $ntf->save();
                        //--------Model Notification-----------//
                    }
                }
            }
        }


        echo 'success';

        return ExitCode::OK;
    }
    public function actionAbsentHakiki($date = null)
    {
        //temporary sja dlu... testing utk staf BSM sja

        $biodata = TblStaffKeselamatan::find()
            ->where(['isActive' => 1])->andWhere(['isExcluded' => 0])->all();
        $today = date('Y-m-d H:i:s');
        $date_before = date('Y-m-d', strtotime($today . ' -1 day'));
        $day_before = date('l', strtotime($today . ' -1 day'));
        //    var_dump(count($biodata));
        if ($date) {
            $date_before = $date;
            $day_before = date('l', strtotime($date));
        }

        $bil = 0;

        foreach ($biodata as $bio) {

            $exist = TblRekod::findOne(['icno' => $bio->staff_icno, 'tarikh' => $date_before]);

            //    var_dump($exist);die;
            if (!$exist) {
                //check klu tidak perlu absent
                $absent = TblRekod::checkAbsent($bio->staff_icno, $date_before);
                // echo 'd';die;
                if ($absent === FALSE) {
                    // echo 'd';die;
                    $model = new TblRekod();

                    $model->icno = $bio->staff_icno;
                    $model->tarikh = $date_before;
                    $model->day = $day_before; // output: current day.
                    $model->absent = '1';
                    $model->wp_id = (TblShiftKeselamatan::lastwp($bio->staff_icno) == '') ? 1 : TblShiftKeselamatan::lastwp($bio->staff_icno);
                    $model->save();

                    $bil++;

                    //                    $btn = Html::a('disini', ['/kehadiran/remark', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']);
                    //----------Model Notification ---------//
                    $ntf = new Notification();
                    $ntf->icno = $bio->staff_icno;
                    $ntf->title = 'Kehadiran';
                    $ntf->content = "Anda Tidak Hadir / Absent pada $date_before ($day_before). Sila buat catatan / Alasan";
                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                    $ntf->save();
                    //--------Model Notification-----------//
                }
            }
        }

        echo $bil;
        return ExitCode::OK;
    }

    public function actionAbsentOt($date = null)
    {

        $biodata = TblStaffKeselamatan::find()
            ->where(['isActive' => 1])->andWhere(['isExcluded' => 0])->all();
        //    var_dump(count($biodata));die;
        $today = date('Y-m-d H:i:s');
        $date_before = date('Y-m-d', strtotime($today . ' -1 day'));
        $day_before = date('l', strtotime($today . ' -1 day'));
        //        var_dump($date_before);die;

        if ($date) {
            $date_before = $date;
            $day_before = date('l', strtotime($date));
        }

        $bil = 0;

        foreach ($biodata as $bio) {

            $exist = TblRekodOt::findOne(['icno' => $bio->staff_icno, 'tarikh' => $date_before]);

            //            var_dump($exist);
            if (!$exist) {
                //check klu tidak perlu absent
                $absent = TblRekodOt::checkAbsent($bio->staff_icno, $date_before);
                //echo 'd';die;
                if ($absent === FALSE) {
                    //echo 'd';die;
                    $model = new TblRekodOt();
                    //echo 'd';die;

                    $model->icno = $bio->staff_icno;
                    $model->tarikh = $date_before;
                    $model->day = $day_before; // output: current day.
                    $model->absent = '1';
                    $model->wp_id = (TblOt::lastot($bio->staff_icno) == '') ? 1 : TblOt::lastot($bio->staff_icno);
                    $model->save();

                    $bil++;

                    //    $btn = Html::a('disini', ['/keselamatan/tindakan-ketidakpatuhan', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']);
                    // ----------Model Notification ---------//
                    $ntf = new Notification();
                    $ntf->icno = $bio->staff_icno;
                    $ntf->title = 'Kehadiran Keselamatan';
                    $ntf->content = "Anda Tidak Hadir / Absent pada $date_before ($day_before). Sila buat catatan / Alasan";
                    $ntf->ntf_dt = date('Y-m-d H:i:s');
                    $ntf->save();
                    //--------Model Notification-----------//
                }
            }
        }

        echo $bil;

        return ExitCode::OK;
    }

    /**
     * Ni untuk check yang ada sda time in.. tp teda time out... status incomplete
     * 
     * @return EXITCODE
     */
    public function actionIncomplete()
    {

        //        $today = '2018-10-18';
        $today = date('Y-m-d');
        $date_before = date('Y-m-d', strtotime($today . ' -1 day'));

        $result = TblRekod::updateAll(['incomplete' => 1], ['tarikh' => $date_before, 'absent' => 0, 'time_out' => NULL, 'status_out' => NULL]);

        echo $result;

        return ExitCode::OK;
    }

    public function actionIncompleteOt()
    {

        //        $today = '2018-10-18';
        $today = date('Y-m-d');
        $date_before = date('Y-m-d', strtotime($today . ' -1 day'));

        $result = TblRekodOt::updateAll(['incomplete' => 1], ['tarikh' => $date_before, 'absent' => 0, 'time_out' => NULL, 'status_out' => NULL]);

        echo $result;

        return ExitCode::OK;
    }

    public function actionWarnakad()
    {

        //cari dulu staf yang aktif

        $biodata = TblStaffKeselamatan::find()->andWhere(['=', 'isExcluded', '0'])->all();

        //    var_dump($biodata);die;
        //Task Scheduler akan run pada setiap 4hb pada setiap bulan. so date suppose to be 201X-XX-04
        //Month skg
        //Month sblm
        $today = date('Y-m-d');
        // $today = '2022-01-10';
        $month_now = date('m');
        // $month_now = '1';
        $year_now = date('Y');
        $month_before = date('m', strtotime($today . ' -1 month'));
// var_dump($month_now,$month_before);die;
        //Month sblm

        if ($month_before == 12) {
            $year = date('Y', strtotime($today . ' -1 year'));
        } else {
            $year = $year_now;
        }


        //run semua staf yang aktif
        foreach ($biodata as $bio) {

            //cari kalau ada yang sda ada kad pada bulan semasa
            $find_kad = TblWarnaKad::find()->where('icno=:icno AND MONTH(month_date) =:month AND YEAR(month_date) =:year', [':icno' => $bio->staff_icno, ':month' => $month_now, ':year' => $year_now])->one();
            $find_kad_before = TblWarnaKad::find()->where('icno=:icno AND YEAR(month_date) =:year AND MONTH(month_date) =:month', [':icno' => $bio->staff_icno, ':month' => $month_before, ':year' => $year])->one();
   
            // $find_kad_before = TblWarnaKad::find()->where('icno=:icno AND MONTH(month_date) =:month', [':icno' => $bio->staff_icno, ':month' => $month_before])->one();

            //klu x jumpa kad.. auto kasi kuning sja
            $color = $find_kad_before ? $find_kad_before->color : 'YELLOW';
            //klu tiada baru add dalam table tbl_wp
            if (!$find_kad) {

                $warna = new TblWarnaKad();
                $warna->month_date = $today;
                $warna->icno = $bio->staff_icno;
                $warna->color = TblRekod::kadWarna(TblRekod::totalRejected($bio->staff_icno, $month_before,$year), $color);
                $warna->ketidakpatuhan = TblRekod::totalSalah($bio->staff_icno, $month_before,$year);
                $warna->approved = TblRekod::totalApproved($bio->staff_icno, $month_before,$year);
                $warna->disapproved = TblRekod::totalRejected($bio->staff_icno, $month_before,$year);

                //                var_dump($warna);die;
                $warna->save(false);

                echo $bio->staff_icno . '- salah: ' . TblRekod::totalSalah($bio->staff_icno, $month_before,$year) . ', rejected: ' . TblRekod::totalRejected($bio->staff_icno, $month_before,$year) . ', approved: ' . TblRekod::totalApproved($bio->staff_icno, $month_before,$year) . ', Warna: ' . TblRekod::kadWarna(TblRekod::totalRejected($bio->staff_icno, $month_before,$year), 'YELLOW') . "\n";
            }
        }

        return ExitCode::OK;
    }
    public function getStaff()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'staff_icno']);
    }
    //utk auto reject mana yang tida tidakan.
    public function actionAutoreject()
    {

        $today = date('Y-m-d');
        $year_now = date('Y');

        //Month sblm
        $month_before = date('m', strtotime($today . ' -1 month'));

        if ($month_before == 12) {
            $year = date('Y', strtotime($today . ' -1 year'));
        } else {
            $year = $year_now;
        }

        $model = TblRekod::find()->where('MONTH(tarikh) =:month AND YEAR(tarikh) =:year AND (incomplete = 1 OR absent = 1 OR external = 1 OR status_in IS NOT NULL OR status_out IS NOT NULL) AND (remark_status IS NULL OR remark_status = "ENTRY")', [':month' => $month_before, ':year' => $year])->all();
//   var_dump($model);die;
        if ($model) {

            foreach ($model as $val) {

                $m = TblRekod::findOne($val->id);
                $m->remark_status = 'REJECTED';
                $m->app_remark = '--AUTO REJECT BY SYSTEM--';
                $m->app_dt = date('Y-m-d H:i:s');
                $m->update();
            }
        }

        echo count($model);

        return ExitCode::OK;
    }
    public function actionAutorejectrollcall()
    {

        $today = date('Y-m-d');
        $year_now = date('Y');

        //Month sblm
        $month_before = date('m', strtotime($today . ' -1 month'));

        if ($month_before == 12) {
            $year = date('Y', strtotime($today . ' -1 year'));
        } else {
            $year = $year_now;
        }
// $model = TblRollcall::find()->where('MONTH(date)=:month');
        $model = TblRollcall::find()->where('MONTH(date) =:month AND YEAR(date) =:year AND (THTC = 1 
        OR THBH = 1 OR THH = 1 OR THBLMJ = 1 OR THBLMT = 1 OR THBKWLN = 1 OR THLMJ = 1 OR THLMT = 1 OR THKWLN = 1) AND 
        (status IS NULL OR status = "ENTRY" OR status = "REMARKED")', [':month' => $month_before, ':year' => $year])->all();
//   var_dump($model);die;
        if ($model) {

            foreach ($model as $val) {

                $m = TblRollcall::findOne($val->id);
                $m->status = 'REJECTED';
                $m->app_remark = '--AUTO REJECT BY SYSTEM--';
                $m->app_dt = date('Y-m-d H:i:s');
                $m->update();
            }
        }

        echo count($model);

        return ExitCode::OK;
    }

    public function actionAutorejectOt()
    {

        //        $today = '2019-03-01';
        $today = date('Y-m-d');
        //Month sblm
        $month_before = date('m', strtotime($today . ' -1 month'));

        $model = TblRekodOt::find()->where('MONTH(tarikh) =:month AND (incomplete = 1 OR absent = 1 OR external = 1 OR status_in IS NOT NULL OR status_out IS NOT NULL) AND (remark_status IS NULL OR remark_status = "ENTRY")', [':month' => $month_before])->all();

        if ($model) {

            foreach ($model as $val) {

                $m = TblRekodOt::findOne($val->id);
                $m->remark_status = 'REJECTED';
                $m->app_remark = '--AUTO REJECT BY SYSTEM--';
                $m->app_dt = date('Y-m-d H:i:s');
                $m->update();
            }
        }

        echo count($model);

        return ExitCode::OK;
    }

    public function actionSendPendingTask()
    {

        $biodata = Tblprcobiodata::find()->where(['Status' => 1])->asArray()->all();

        $set_from = ['hronline-noreply@ums.edu.my' => 'HRONLINE v4.0'];
        $subject = 'Senarai ketidakpatuhan staf menunggu tindakan anda';

        foreach ($biodata as $bio) {
            if (TblRekod::totalPendingKetidakpatuhan($bio['ICNO'], TRUE) != 0) {
                $total = TblRekod::totalPendingKetidakpatuhan($bio['ICNO'], TRUE);
                $model = TblRekod::totalPendingKetidakpatuhan($bio['ICNO'], FALSE, TRUE);

                $email = $bio['COEmail'];
                $name = $bio['CONm'];

                if ($email) {
                    $set_to = [$email => $name];
                    Yii::$app->mailer->compose('pending_task_ketidakpatuhan', ['model' => $model, 'total' => $total, 'bil' => 1])
                        ->setFrom($set_from)
                        ->setTo($set_to)
                        ->setSubject($subject)
                        ->send();
                }
            }
        }

        return ExitCode::OK;
    }

    //**simpan dlu ni function
    function getDaysInYearMonth(int $year, int $month, string $format)
    {
        $date = DateTime::createFromFormat("Y-n", "$year-$month");

        $datesArray = array();
        for ($i = 1; $i <= $date->format("t"); $i++) {
            $datesArray[] = DateTime::createFromFormat("Y-n-d", "$year-$month-$i")->format($format);
        }

        return $datesArray;
    }

    public function actionGenReport()
    {
        //        $icno = '890426495037';


        $biodata = Tblprcobiodata::find()->where(['Status' => 1])->asArray()->all();


        $year = 2019;
        $mth = 5;

        $var = $this->getDaysInYearMonth($year, $mth, 'Y-m-d');
        foreach ($biodata as $bio) {
            foreach ($var as $k => $v) {

                $report = new TblReports();
                $report->icno = $bio['ICNO'];
                $report->tarikh = $v;
                $report->day = TblRekod::DisplayDay($v);
                $report->wbb = TblRekod::DisplayWbb($bio['ICNO'], $v);
                $report->in_time = TblRekod::DisplayTime($bio['ICNO'], $v, 1);
                $report->out_time = TblRekod::DisplayTime($bio['ICNO'], $v, 2);
                $report->non_compliance_sts = TblRekod::IncStatus($bio['ICNO'], $v);
                $report->leave_outstation = TblRekod::DisplayCutiRaw($bio['ICNO'], $v);
                $report->working_hours = TblRekod::DisplayHours($bio['ICNO'], $v);
                $report->remark = TblRekod::RemarkStatusRaw($bio['ICNO'], $v);
                $report->in_lng_lat = TblRekod::DisplayLocIn($bio['ICNO'], $v);
                $report->out_lng_lat = TblRekod::DisplayLocOut($bio['ICNO'], $v);
                $report->rekod_id = TblRekod::IdByDate($bio['ICNO'], $v);
                $report->create_at = date('Y-m-d H:i:s');
                $report->save(false);
                //            if ($report->save()) {
                //                echo $v . '|' .
                //                TblRekod::DisplayDay($v) . '|' .
                //                TblRekod::DisplayWbb($icno, $v) . '|' .
                //                TblRekod::DisplayTime($icno, $v, 1) . '|' .
                //                TblRekod::DisplayTime($icno, $v, 2) . '|' .
                //                TblRekod::IncStatus($icno, $v) . '|' .
                //                TblRekod::DisplayCutiRaw($icno, $v) . '|' .
                //                TblRekod::DisplayHours($icno, $v) . '|' .
                //                TblRekod::RemarkStatusRaw($icno, $v) . '|' .
                //                TblRekod::DisplayLocIn($icno, $v) . '|' .
                //                TblRekod::DisplayLocOut($icno, $v) . '|' .
                //                TblRekod::IdByDate($icno, $v) . '|' .
                //                PHP_EOL;
                //            }
            }
        }

        return ExitCode::OK;
    }

    public function actionReminder()
    {
        $today = date('Y-m-d');
        $date_before = date('Y-m-d', strtotime($today . ' -1 day'));
        $result = TblRollcall::find()->where(['date' => $date_before])->andWhere(['status' => 'SIMPAN'])->all();
        $bil = 0;
        foreach ($result as $r) {
            $ntf = new Notification();
            $ntf->icno = $r->do_icno;
            $ntf->title = "Kehadiran Rollcall Keselamatan";
            $ntf->content = "Anda Mempunyai Tindakan Rollcall pada " . $date_before . " yang Perlu Tindakan Dari Anda. Sila Buat Tindakan Dengan Serta Merta di Ruangan Rollcall Manual";
            $ntf->ntf_dt = date('Y-m-d H:i:s');
            $ntf->save();
            $bil++;
        }


        echo $bil;

        return ExitCode::OK;
    }

    //check klau ada yg tertinggal sbb task scheduler tidak run

    public function actionCheckinga()
    {

        $today = date('Y-m-d');
        $month = date('m');
        $yr = date('Y');
        $before = date('Y-m-d', strtotime($today . ' -1 day'));
        $model = TblRekod::find()->where('YEAR(tarikh) =:yr AND MONTH(tarikh) =:month AND time_in IS NULL AND time_out IS NULL AND tarikh <= :before AND remark_status IS NULL', [':month' => $month,':before' =>$before,':yr' =>$yr])->all();
        //  var_dump($model);die;

        if ($model) {

            foreach ($model as $val) {

                $m = TblRekod::findOne($val->id);
                $m->absent = '1';

                $m->update();
            }
        }

        echo count($model);

        return ExitCode::OK;
    }
    public function actionCheckingI()
    {
        $today = date('Y-m-d');
        $month = date('m');
        $yr = date('Y');
        $before = date('Y-m-d', strtotime($today . ' -1 day'));
        $model = TblRekod::find()->where('YEAR(tarikh) =:yr AND MONTH(tarikh) =:month AND time_out IS NULL AND time_in IS NOT NULL AND tarikh <= :before AND remark_status IS NULL', [':month' => $month,':before' =>$before,':yr' =>$yr])->all();
      
        if ($model) {

            foreach ($model as $val) {

                $m = TblRekod::findOne($val->id);
                $m->incomplete = '1';

                $m->update();
            }
        }

        echo count($model);

        return ExitCode::OK;
    }

    
    public function actionAutoApprove($tarikh)
    {

        $model = TblRekod::find()->where(['tarikh' => $tarikh])
        ->andWhere(['!=', 'remark_status', 'APPROVED'])
        ->orFilterWhere(['late_in'=>1, 'early_out'=>1,'absent'=>1,'incomplete'=>1,'external'=>1])
        ->all();

        $sql = "select * from keselamatan.tbl_rekod a 
        where a.remark_status != 'APPROVED'
        and (a.late_in  = 1
        OR a.early_out = 1
        OR a.`external`  = 1
        OR a.incomplete  = 1
        OR a.absent  = 1)
        and a.tarikh =:tarikh";

        $model = TblRekod::findBySql($sql,['tarikh'=>$tarikh])->all();

        if ($model) {

            // foreach ($model as $m) {

            //     $m->auto_approve = 1;
            //     $m->remark_status = 'APPROVED';
            //     $m->app_remark = '--AUTO APPROVE BY SYSTEM (SYSTEM ERROR)--';
            //     $m->app_dt = date('Y-m-d H:i:s');
            //     $m->update();
            // }
            echo count($model);
        }

        

        return ExitCode::OK;
    }

}
