<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use app\models\kehadiran\TblRekod;
use app\models\hronline\Tblprcobiodata;
use app\models\kehadiran\TblWp;
use app\models\kehadiran\TblWarnaKad;
use app\models\kehadiran\TblReports;
use DateTime;
use app\models\hronline\TblSysEmailQueue;
use app\models\kehadiran\TblOvertimes;
use app\models\kehadiran\TblWfh;
use app\models\kehadiran\TblYears;
// use yii\helpers\VarDumper;

/**
 * command ni akan run pada setiap hari pada jam 1 pagi;
 * kenapa jam 1 pagi, kerana jam 1 pagi keadaan mula tenang.. suasana begitu asyik sekali..
 * every function akan detect kehadiran day before command ni kena run..
 * Run command ni pakai Windows Task scheduler[weekly-isnin hingga jumaat].
 */
class KehadiranController extends Controller
{

    /**
     * Untuk detect siapa yang tiada rekod langsung[no time in/out] pada hari sebelum console ni kena run;
     * 
     * @return EXITCODE;
     * 
     */
    public function actionAbsent($date = null)
    {
        //temporary sja dlu... testing utk staf BSM sja
        $biodata = Tblprcobiodata::find()
            ->where(['Status' => 1])
            ->andWhere(['NOT IN', 'gredJawatan', [118, 119, 295, 302, 303, 360, 388, 389]])
            ->all();



        $today = date('Y-m-d H:i:s');
        $date_before = date('Y-m-d', strtotime($today . ' -1 day'));
        $day_before = date('l', strtotime($today . ' -1 day'));

        if ($date) {
            $date_before = $date;
            $day_before = date('l', strtotime($date));
        }

        $bil = 1;

        foreach ($biodata as $bio) {

            $exist = TblRekod::findOne(['icno' => $bio->ICNO, 'tarikh' => $date_before]);

            if (!$exist) {

                //check klu tidak perlu absent
                $absent = TblRekod::checkAbsent($bio->ICNO, $date_before);

                if ($absent === FALSE) {

                    $model = new TblRekod();

                    $model->icno = $bio->ICNO;
                    $model->tarikh = $date_before;
                    $model->day = $day_before; // output: current day.
                    $model->absent = 1;
                    $model->wp_id = (TblWp::curr_wp($bio->ICNO) == '') ? 1 : TblWp::curr_wp($bio->ICNO);
                    $model->save();

                    $bil++;
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
    public function actionIncomplete($date = null)
    {

        $today = date('Y-m-d');
        $date_before = date('Y-m-d', strtotime($today . ' -1 day'));

        if ($date) {
            $date_before = $date;
        }

        $models = TblRekod::find()->joinWith(['wbb'])->where([
            'tbl_rekod.tarikh' => $date_before,
            'tbl_rekod.absent' => 0,
            'tbl_rekod.time_out' => NULL,
            'tbl_rekod.early_out' => 0,
            'ref_wp.no_incomplete' => 0,
            'ref_wp.next_day' => 0 //sbb esk dia bru clock out
        ])->all();
        $total = 1;
        $test = 1;
        foreach ($models as $model) {

            $test = $total++;
            $model->incomplete = 1;
            $model->update(false); // skipping validation as no user input is involved
        }

        echo $test;

        return ExitCode::OK;
    }

    public function actionWarnakad()
    {

        //cari dulu staf yang aktif
        $biodata = Tblprcobiodata::findAll(['Status' => 1]);

        //Task Scheduler akan run pada setiap 4hb pada setiap bulan. so date suppose to be 20XX-XX-04
        //tukar sda ke 10hb
        $today = date('Y-m-d');
        $month_now = date('m');
        $year_now = date('Y');

        //Month sblm
        $month_before = date('m', strtotime($today . ' -1 month'));

        if ($month_before == 12) {
            $year = date('Y', strtotime($today . ' -1 year'));
        } else {
            $year = $year_now;
        }


        //run semua staf yang aktif
        foreach ($biodata as $bio) {

            //cari kalau ada yang sda ada kad pada bulan semasa
            $find_kad = TblWarnaKad::find()->where('icno=:icno AND MONTH(month_date) =:month AND YEAR(month_date) =:year', [':icno' => $bio->ICNO, ':month' => $month_now, ':year' => $year_now])->one();
            $find_kad_before = TblWarnaKad::find()->where('icno=:icno AND YEAR(month_date) =:year AND MONTH(month_date) =:month', [':icno' => $bio->ICNO, ':month' => $month_before, ':year' => $year])->one();

            //klu x jumpa kad.. auto kasi kuning sja
            $color = $find_kad_before ? $find_kad_before->color : 'YELLOW';

            //klu tiada baru add dalam table tbl_wp
            if (!$find_kad) {

                $warna = new TblWarnaKad();
                $warna->month_date = $today;
                $warna->icno = $bio->ICNO;
                $warna->color = TblRekod::kadWarna(TblRekod::totalRejected($bio->ICNO, $month_before, $year), $color);
                $warna->ketidakpatuhan = TblRekod::totalSalah($bio->ICNO, $month_before, $year);
                $warna->approved = TblRekod::totalApproved($bio->ICNO, $month_before, $year);
                $warna->disapproved = TblRekod::totalRejected($bio->ICNO, $month_before, $year);

                $warna->save(false);

                echo $bio->CONm . '- salah: ' . TblRekod::totalSalah($bio->ICNO, $month_before, $year) . ', rejected: ' . TblRekod::totalRejected($bio->ICNO, $month_before, $year) . ', approved: ' . TblRekod::totalApproved($bio->ICNO, $month_before, $year) . ', Warna: ' . TblRekod::kadWarna(TblRekod::totalRejected($bio->ICNO, $month_before, $year), 'YELLOW') . "\n";
            }
        }

        return ExitCode::OK;
    }

    //utk auto reject mana yang tida tidakan.
    public function actionAutoreject()
    {

        //Task Scheduler akan run pada setiap 4hb pada setiap bulan. so date suppose to be 20XX-XX-04
        $today = date('Y-m-d');
        $year_now = date('Y');

        //Month sblm
        $month_before = date('m', strtotime($today . ' -1 month'));

        if ($month_before == 12) {
            $year = date('Y', strtotime($today . ' -1 year'));
        } else {
            $year = $year_now;
        }


        $model = TblRekod::find()->where('MONTH(tarikh) =:month AND YEAR(tarikh) =:year AND (incomplete = 1 OR absent = 1 OR external = 1 OR late_in = 1 OR early_out = 1) AND (remark_status IS NULL OR remark_status = "ENTRY")', [':month' => $month_before, ':year' => $year])->all();

        if ($model) {

            foreach ($model as $val) {

                $m = TblRekod::findOne($val->id);
                $m->remark_status = 'REJECTED';
                $m->no_remark = (empty($m->reason_id)) ? 1 : 0; //klu tiada reason_id kasi 1 tu no_remark(tiada remark drpd staf)
                $m->no_action = (!empty($m->reason_id)) ? 1 : 0; //klu ada reason_id kasi 1 tu no_action(tiada tindakan drpd pegawai)
                $m->auto_rejected = 1;
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

        $set_from = ['eoffice.ums@ums.edu.my' => 'HRONLINE v4.0'];
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

    public function actionSendEmailCuti()
    {

        $models = TblSysEmailQueue::find()->where(['success' => 0])->orderBy(['date_published' => SORT_DESC])->limit(1000)->all();

        foreach ($models as $model) {

            $email = Yii::$app->mailer->compose('email_cuti', ['content' => $model->message])
                ->setFrom([$model->from_email => $model->from_name])
                ->setTo([$model->to_email => $model->to_name])
                ->setSubject($model->subject)
                ->send();

            if ($email) {
                $model->success = 1;
                $model->update(false);
            }
        }
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

    public function actionGenReport($year, $mth)
    {

        $biodata = Tblprcobiodata::find()->where(['Status' => 1])->asArray()->all();

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
            }
        }

        return ExitCode::OK;
    }

    public function actionGenList()
    {
        $biodata = Tblprcobiodata::findAll(['Status' => 1]);

        foreach ($biodata as $bio) {
            echo $bio->ICNO . '|' . $bio->jawatan->job_category . '|' . TblWp::curr_wp($bio->ICNO, TRUE) . "\n";
        }
    }

    public function actionGenOtData($date = null)
    {

        if (!$date) {
            $today = date('Y-m-d');
            $date = date('Y-m-d', strtotime($today . ' -1 day'));
        }


        $year = date('Y');

        TblOvertimes::deleteAll(['DATE(act_clock_in)' => $date]);

        $rekod = TblRekod::find()
            ->where(['tarikh' => $date])
            ->andWhere(['not', ['time_in' => null]])
            ->andWhere(['not', ['time_out' => null]])
            ->all();

        foreach ($rekod as $rkd) {

            $att_id = "$year-$rkd->id";

            $model_ot = new TblOvertimes();
            $model_ot->id = $rkd->id;
            $model_ot->att_id = $att_id;
            $model_ot->staff_id = $rkd->kakitangan->COOldID;
            $model_ot->staff_nric = $rkd->icno;
            $model_ot->shift_hr_in = $rkd->shiftHrIn;
            $model_ot->shift_hr_out = $rkd->shiftHrOut;
            $model_ot->act_clock_in = $rkd->time_in;
            $model_ot->act_clock_out = $rkd->time_out;
            $model_ot->ot_type = 'OT';
            $model_ot->save(false);
        }

        echo count($rekod) . ' data OK!';

        return ExitCode::OK;
    }

    /**
     * ni utk tambah thun yang aktif setiap 1hb tiap tahun
     * @return type
     */
    public function actionAddYear()
    {

        $year = date('Y');

        $model = TblYears::findOne(['year' => $year]);

        if (!$model) {
            $model = new TblYears();
            $model->year = $year;
            $model->status = 1;
            $model->save();
        }

        return ExitCode::OK;
    }

    public function actionCheckIncomplete($month = null, $year = null)
    {

        $count = 0;

        if ($month != null) {
            $month = date('m');
        }

        if ($year != null) {
            $year = date('Y');
        }

        echo 'start: ' . date('Y-m-d H:i:s') . ' - ';

        $sql = 'SELECT * FROM attendance.tbl_rekod WHERE MONTH(tarikh)=:bulan AND YEAR(tarikh)=:year AND(absent = 1 OR incomplete = 1)';
        $rekod = TblRekod::findBySql($sql, [':bulan' => $month, ':year' => $year])->all();

        foreach ($rekod as $r) {

            $absent = TblRekod::checkAbsent($r->icno, $r->tarikh);

            if ($absent) {
                $model = TblRekod::findOne(['id' => $r->id]);
                if ($model->delete()) {
                    $count++;
                }
            }
        }

        echo 'end : ' . date('Y-m-d H:i:s') . ' (' . $count . ')';

        return ExitCode::OK;
    }

    // public function actionGenYearPdfRpt($icno = 890426495037, $year = 2020){

    public function actionSetAutoWfhAll($remark, $date)
    {

        $new_date = date_create($date);
        $dmy = date_format($new_date, "d/m/Y");

        $sql = "SELECT a.ICNO FROM hronline.tblprcobiodata a 
        LEFT JOIN attendance.tbl_wfh b ON a.ICNO = b.icno AND b.start_date=:to_date AND b.end_date =:to_date 
        LEFT JOIN hronline.gredjawatan c ON a.gredJawatan = c.id
        WHERE a.Status != 6 AND b.icno IS NULL 
        AND NOT (c.gred_skim = 'KP' AND c.gred_no < 41) 
        AND a.DeptId NOT IN (164)"; //kecuali HUMS

        $biodata = TblWp::findBySql($sql, [':to_date' => $date,])->asArray()->all();

        foreach ($biodata as $b) {

            $new_wfh = new TblWfh();

            $new_wfh->icno = $b['ICNO'];
            $new_wfh->full_date = $dmy . ' to ' . $dmy;
            $new_wfh->start_date = $date;
            $new_wfh->end_date = $date;
            $new_wfh->tempoh = 1;
            $new_wfh->remark = $remark;
            $new_wfh->status = 'APPROVED';

            $new_wfh->save(false);
        }


        echo count($biodata);
    }

    /**
     * untuk remove absent yang lambat kena keyin cutinya
     * $icno : no kp staf
     * startdate : tarikh mula cuti
     * enddate : tarikh tamat cuti
     * 
     * sekiranya 2 parameter date tidak d provide, delete semua absent yang ada cuti
     */
    public function actionRemoveAbsent($icno, $startdate = null, $enddate = null)
    {

        $total = 0;
        $model = TblRekod::find()
            ->where(['icno' => $icno])
            ->orWhere(['incomplete'=>1,'absent'=>1,'late_in'=>1])
            ->andFilterWhere(['between', 'tarikh', $startdate, $enddate])
            ->all();

        foreach ($model as $att) {

            if ($att->notAbsent) {
                $total++;
                if ($att->delete()) {
                    echo $att->tarikh . " DELETED" . "\n";
                }
            }
        }
        echo "\n";
        echo "Original Absent : " . count($model) . "\n\n";
        echo "Deleted Absent : " . $total . "\n\n";

        return ExitCode::OK;
    }


    public function actionRemoveAbsentAll($month = null, $year = null)
    {

        if (!$month) {

            $month = date('m');
            $year = date('Y');
        }

        $total = 0;
        $model = TblRekod::find()
            ->where(['<>', 'remark_status', 'APPROVED'])
            ->orWhere(['incomplete'=>1,'absent'=>1,'late_in'=>1])
            ->andFilterWhere(['MONTH(tarikh)' => $month, 'YEAR(tarikh)' => $year])
            ->all();

        foreach ($model as $att) {

            if ($att->notAbsent) {
                $total++;
                if ($att->delete()) {
                    echo $att->tarikh . " DELETED" . "\n";
                }
            }
        }
        echo "\n";
        echo "Original Absent : " . count($model) . "\n\n";
        echo "Deleted Absent : " . $total . "\n\n";

        return ExitCode::OK;
    }

    public function actionAutoApprove($tarikh)
    {

        // $model = TblRekod::find()->where(['tarikh' => $tarikh])
        // ->andWhere(['!=', 'remark_status', 'APPROVED'])
        // ->orFilterWhere(['late_in'=>1, 'early_out'=>1,'absent'=>1,'incomplete'=>1,'external'=>1])
        // ->all();

        $sql = "select * from attendance.tbl_rekod a 
        where a.remark_status != 'APPROVED'
        and (a.late_in  = 1
        OR a.early_out = 1
        OR a.`external`  = 1
        OR a.incomplete  = 1
        OR a.absent  = 1)
        and a.tarikh =:tarikh";

        $model = TblRekod::findBySql($sql,['tarikh'=>$tarikh])->all();

        if ($model) {

            foreach ($model as $m) {

                $m->auto_approve = 1;
                $m->remark_status = 'APPROVED';
                $m->app_remark = '--AUTO APPROVE BY SYSTEM (SYSTEM ERROR)--';
                $m->app_dt = date('Y-m-d H:i:s');
                $m->update();
            }
            echo count($model);
        }

        

        return ExitCode::OK;
    }
}
