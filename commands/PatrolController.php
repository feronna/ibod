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
use app\models\patrol\PatrolRating;
use app\models\patrol\PatrolYearlyReport;
use app\models\patrol\Rekod;
use DateTime;
use yii\helpers\Html;;

/**
 * command ni akan run pada setiap hari pada jam 1 pagi;
 * kenapa jam 1 pagi, kerana jam 1 pagi keadaan mula tenang.. suasana begitu asyik sekali..
 * every function akan detect kehadiran day before command ni kena run..
 * Run command ni pakai Windows Task scheduler[weekly-isnin hingga jumaat].
 */
class PatrolController extends Controller
{

    /**
     * Untuk detect siapa yang tiada rekod langsung[no time in/out] pada hari sebelum console ni kena run;
     * 
     * @return EXITCODE;
     * 
     */
// update pos according to shift
    public function actionUpdatePos()
    {

        $today = date('Y-m-d');

        $model = TblStaffKeselamatan::find()->where(['isActive' => 1])->all();
        foreach ($model as $v) {
            $shift = TblShiftKeselamatan::find()->where(['tarikh' => $today, 'icno' => $v->staff_icno])->one();
            if ($shift) {
                $v->pos_kawalan_id = $shift->pos_kawalan_id;
                $v->month = date('m');
                $v->year = date('Y');
                $v->save(false);
            }
        }

        echo count($model);


        return ExitCode::OK;
    }
    public static function rating($percent)
    {
        // var_dump($percent);die;
        if ($percent == 0) {
            $val = '0';
        } else
        if (($percent >= 0) && ($percent < 20)) {
            $val = '1';
        } else
        if (($percent >= 20) && ($percent < 40)) {
            $val = '2';
        } else
        if (($percent >= 40) && ($percent < 60)) {
            $val = '3';
        } else
        if (($percent >= 60) && ($percent < 80)) {
            $val = '4';
        } else {
            $val = '5';
        }
        return $val;
    }
//rating and yearly report by month
    public function actionRating()
    {

        $biodata = TblStaffKeselamatan::find()->andWhere(['=', 'isExcluded', '0'])
        ->andWhere(['isActive' => 1])->all();

        //Month skg
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
            $find_rating = PatrolRating::find()->where(['icno' =>$bio->staff_icno])->andWhere(['MONTH(month_date)' => $month_now])->andWhere(['YEAR(month_date)' => $year])->one();
            $find_rating_before = PatrolRating::find()->where(['icno' =>$bio->staff_icno])->andWhere(['MONTH(month_date)' => $month_before])->andWhere(['YEAR(month_date)' => $year])->one();
            // echo 'd';die;
           
            //klu x jumpa kad.. auto kasi kuning sja
            $color = $find_rating_before ? $find_rating_before->rating : '0';
            $color = $find_rating_before ? $find_rating_before->percentage : '0';
            $date = $year.'-'.$month_before.'-'.date('d');
            $var = $this->getDaysInYearMonth($year, $month_before, 'Y-m-d');
            //klu tiada baru add dalam table tbl_wp
            if (!$find_rating) {
                    // echo 'd';die;
                $rating = new PatrolRating();
                $rating->month_date = $date;
                $rating->icno = $bio->staff_icno;
                $rating->jum_hakiki = Rekod::countpatrolmonthlyhakiki($bio->staff_icno, $month_before,$year);
                $rating->jum_lm = Rekod::countpatrolmonthlylmj($bio->staff_icno, $month_before,$year);
                $rating->percentage_hakiki = Rekod::percents($bio->staff_icno, $var,3);
                $rating->percentage_lmj = Rekod::percents($bio->staff_icno, $var,2);
                $rating->rating_hakiki = Rekod::rating(Rekod::percents($bio->staff_icno, $var,3));
                $rating->rating_lmj = Rekod::rating(Rekod::percents($bio->staff_icno, $var,2));
                //                var_dump($warna);die;
                $rating->save(false);

                echo $bio->staff_icno;
            }
        }

        return ExitCode::OK;
    }
    function getMonthsInYear(int $year, int $month, string $format)
    {
        //        var_dump($format);die;
        $date = DateTime::createFromFormat("Y-n", "$year-$month");

        $datesArray = array();
        for ($i = $month; $i <= 12; $i++) {
            $datesArray[] = TblRekod::viewBulan($i);
        }
        return $datesArray;
    }
    function getDaysInYearMonth(int $year, int $month, string $format)
    {
        $date = DateTime::createFromFormat("Y-n", "$year-$month");
        // var_dump($year);die;
        $datesArray = array();
        for ($i = 1; $i <= $date->format("t"); $i++) {
            $datesArray[] = DateTime::createFromFormat("Y-n-d", "$year-$month-$i")->format($format);
        }

        return $datesArray;
    }
}
