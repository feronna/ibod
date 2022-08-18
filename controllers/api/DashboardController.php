<?php

namespace app\controllers\api;

use app\models\cuti\SetPegawai;
use app\models\cuti\TblRecords;
use app\models\hronline\Department;
use app\models\hronline\ServiceStatus;
use app\models\hronline\Tblprcobiodata;
use app\models\kehadiran\TblRekod;
use yii\web\Response;
use Yii;
use app\models\kehadiran\TblWp;
use app\models\kehadiran\RefWp;
use app\models\kehadiran\TblWfh;
use app\models\keselamatan\TblRekod as KeselamatanTblRekod;
use yii\helpers\VarDumper;


class DashboardController extends \yii\base\Controller
{

    public $enableCsrfValidation = false;

    public function beforeAction($action)
    {

        \Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    private function setHeader($status)
    {

        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        $content_type = "application/json; charset=utf-8";

        header($status_header);
        header('Content-type: ' . $content_type);
        header('X-Powered-By: ' . "ums.edu.my");
    }

    private function _getStatusCodeMessage($status)
    {
        $codes = array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }



    /**
     * untuk paparan info di hadapan;
     */
    public function actionGetInfo()
    {

        $params = $_REQUEST;

        $icno = $params['icno'];
        $tarikh = date('Y-m-d');

        $model = TblRekod::findOne(['icno' => $icno, 'tarikh' => $tarikh]);

        $wp_id = TblWp::curr_wp($icno);
        $model_wp = RefWp::findOne(['id' => $wp_id]);

        if ($model) {

            $this->setHeader(200);

            return [
                'status' => 1,
                'btn_text' => 'Clock Out',
                'route' => 'clock-out',
                'message' => 'Record Retrieved!',
                'day' => $model->day,
                'wp_id' => $wp_id,
                'jenis_wp' => $model_wp->jenis_wp,
                'wp_detail' => $model_wp->detail,
                'tarikh' => $model->tarikh,
                'time_in' => $model->formatTimeIn,
                'time_out' => $model->formatTimeOut,
                'total_hours' => $model->total_hours,
                'late_in' => $model->late_in,
                'early_out' => $model->early_out,
                'incomplete' => $model->incomplete,
                'absent' => $model->absent,
                'external' => $model->external,
                'in_lat_lng' => $model->in_lat_lng,
                'out_lat_lng' => $model->out_lat_lng,
                'in_ip' => $model->in_ip,
                'out_ip' => $model->out_ip,
            ];
        } else {
            // $this->setHeader(401);
            return [
                'status' => 1,
                'btn_text' => 'Clock In',
                'route' => 'clock-in',
                'message' => 'No record found',
                'day' => '-',
                'wp_id' => $wp_id,
                'jenis_wp' => $model_wp->jenis_wp,
                'wp_detail' => '-',
                'tarikh' => '-',
                'time_in' => '-',
                'time_out' => '-',
                'total_hours' => 0,
                'late_in' => 0,
                'early_out' => 0,
                'incomplete' => 0,
                'absent' => 0,
                'external' => 0,
                'in_lat_lng' => '',
                'out_lat_lng' => '',
                'in_ip' => '',
                'out_ip' => '',
            ];
        }
    }

    public function actionClockIn()
    {
        $request = Yii::$app->request;

        if ($request->isPost) {

            $icno = $request->post('icno');
            $tarikh = date('Y-m-d');
            $time = date('H:i:s');
            // $ip = $params['ip'];
            $ip = $request->post('ip');
            // $lat_lng = $params['lat_lng'];
            $lat = $request->post('lat');
            $lng = $request->post('lng');
            $lat_lng = $lat . ',' . $lng;

            $wp_id = TblWp::curr_wp($icno);
            $model = TblRekod::findOne(['icno' => $icno, 'tarikh' => $tarikh]);

            $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);

            if (!$biodata) {
                $this->setHeader(401);
                return ['status' => 0, 'messsage' => 'User Not Defined!'];
            }

            if (!$wp_id) {
                $this->setHeader(401);
                return ['status' => 0, 'messsage' => 'Working Hours not yet set, Please Contact Admin!'];
            }

            if (!$model) {

                $model = new TblRekod();

                $checkStatusIn = RefWp::checkStatusIn($icno, $tarikh, $time, $wp_id);
                $checkExternal = TblRekod::checkExternal($icno, $tarikh, $ip, $lat_lng);

                $model->icno = $icno;
                $model->tarikh = $tarikh;
                $model->time_in = $tarikh . ' ' . $time;
                $model->day = date('l'); // output: current day.
                $model->late_in = $checkStatusIn;
                $model->in_lat_lng = $lat_lng;
                $model->in_ip = $ip;
                $model->external = $checkExternal;
                $model->wp_id = $wp_id;

                if ($model->save()) {
                    $this->setHeader(200);
                    //if late in
                    if ($checkStatusIn) {
                        return ['status' => 1, 'type' => 'warning', 'title' => 'Warning, Late',  'message' => 'Non-compliance is detected, Please ensure reason is filled. Thank you'];
                    }

                    //if external
                    if ($checkExternal == 1) {
                        return ['status' => 1, 'type' => 'warning', 'title' => 'Warning, you are out of zone',  'message' => 'Non-compliance is detected, Please ensure reason is filled. Thank you'];
                    }

                    return ['status' => 1, 'type' => 'success', 'title' => 'Clock In',  'message' => 'Your time are recorded successfully'];
                }
            } else {
                $this->setHeader(401);
                return ['status' => 0, 'messsage' => 'Already Clock In!', 'time_in' => $model->time_in];
            }
        }
    }



    public function actionClockOut()
    {
        $request = Yii::$app->request;

        if ($request->isPost) {

            $icno = $request->post('icno');
            $tarikh = date('Y-m-d');
            $time = date('H:i:s');
            // $ip = $params['ip'];
            $ip = $request->post('ip');
            // $lat_lng = $params['lat_lng'];
            $lat = $request->post('lat');
            $lng = $request->post('lng');
            $lat_lng = $lat . ',' . $lng;



            //temp icno
            // if($icno != '820828125051'){
            //     $this->setHeader(401);
            //     return ['status' => 0, 'messsage' => 'Sorry, U r not Malai!'];

            // }


            $wp_id = TblWp::curr_wp($icno);
            $model = TblRekod::findOne(['icno' => $icno, 'tarikh' => $tarikh]);
            $model_wp = RefWp::findOne(['id' => $wp_id]);

            $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);

            if (!$biodata) {
                $this->setHeader(401);
                return ['status' => 0, 'messsage' => 'User Not Defined!'];
            }

            if (!$wp_id) {
                $this->setHeader(401);
                return ['status' => 0, 'messsage' => 'Working Hours not yet set, Please Contact Admin!'];
            }


            if ($model) {

                $checkStatusOut = RefWp::checkStatusOut($icno, $tarikh, $time, $wp_id);
                $checkExternal = TblRekod::checkExternal($icno, $tarikh, $ip, $lat_lng);

                $model->time_out = $tarikh . ' ' . $time;
                $model->total_hours = RefWp::totalHours($model->time_in, $model->time_out, $model_wp->in_start_time);
                $model->external === 1 ? 1 : $checkExternal;
                $model->early_out = $checkStatusOut;

                $model->out_lat_lng = $lat_lng;
                $model->out_ip = $ip;

                if ($model->save()) {
                    $this->setHeader(200);

                    //if early out
                    if ($checkStatusOut) {
                        return ['status' => 1, 'type' => 'warning', 'title' => 'Attention, Early out',  'message' => 'Non-compliance is detected, Please ensure reason is filled. Thank you'];
                    }

                    //if external
                    if ($checkExternal == 1) {
                        return ['status' => 1, 'type' => 'warning', 'title' => 'Warning, you are out of zone',  'message' => 'Non-compliance is detected, Please ensure reason is filled. Thank you'];
                    }

                    return ['status' => 1, 'type' => 'success', 'title' => 'Clock Out',  'message' => 'Your time are recorded successfully'];
                }
            } else {

                $this->setHeader(401);
                return ['status' => 0, 'messsage' => 'Required Clock In!'];
            }
        }
    }

    public function actionListReport()
    {

        if ($params = $_REQUEST) {

            $icno = $params['icno'];

            $currYear = date('Y');
            $currMonth = date('m');
            $currMonthText = date('F');
            $data = [];
            $attRecord = [];

            $model = TblRekod::find()->where([
                'icno' => $icno,
                'MONTH(tarikh)' => $currMonth,
                'YEAR(tarikh)' => $currYear
            ])->all();


            if ($model) {

                foreach ($model as $m) {
                    $attRecord[] = [
                        'id' => $m->id,
                        'tarikh' => $m->formatTarikh,
                        'day' => $m->day,
                        'totalHour' => "$m->workingHours",
                        'timeIn' => $m->formatTimeIn,
                        'timeOut' => $m->formatTimeOut,
                    ];
                }

                $data = [
                    'status' => 1,
                    'statusText' => 'Success!',
                    'icno' => $icno,
                    'month' => $currMonthText,
                    'year' => $currYear,
                    'data' => $attRecord,
                ];
            }

            return $data;
        }
    }

    // public function actionTodayTeam()
    // {
    //     if ($params = $_REQUEST) {

    //         $data = [];
    //         $attRecord = [];

    //         $icno = $params['icno'];

    //         $staff = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();

    //         $team = Tblprcobiodata::find()
    //             ->where(['DeptId' => $staff->DeptId,])
    //             ->andWhere(['!=', 'ICNO', $icno])
    //             ->andWhere(['!=', 'Status', 6])
    //             ->all();

    //         foreach ($team as $mates) {

    //             $file_name = strtoupper(sha1($mates->ICNO));
    //             $todays = TblRekod::TodayAtt($mates->ICNO);

    //             $attRecord[] = [
    //                 'id' => "$mates->COOldID",
    //                 'name' => $mates->CONm,
    //                 'designation' => $mates->jawatan->nama,
    //                 'timeIn' => $todays ? $todays->formatTimeIn : '--:--',
    //                 'timeOut' => $todays ? $todays->formatTimeOut : '--:--',
    //                 'pic' => "https://hronline.ums.edu.my/picprofile/picstf/$file_name.jpeg",
    //             ];
    //         }

    //         $data = [
    //             'deptId' => $staff->DeptId,
    //             'day' => date('d'),
    //             'month' => date('m'),
    //             'year' => date('Y'),
    //             'totalStaff' => count($team),
    //             'teammates' => $attRecord,
    //         ];

    //         return $data;
    //     }
    // }

    public function actionMyLeave()
    {
        // echo 'd';die;
        if ($params = $_REQUEST) {

            $data = [];
            $attRecord = [];

            $icno = $params['icno'];

            $peg = SetPegawai::find()->where(['pelulus_icno' => $icno])->all();

            if (!$peg) {
                $peg = SetPegawai::find()->where(['peraku_icno' => $icno])->all();
            }
            foreach ($peg as $p) {
                $data[] = $p->pemohon_icno;
            }

            $team = Tblprcobiodata::find()
                // ->where(['DeptId' => $staff->DeptId,])
                ->where(['IN', 'ICNO', $data])
                ->andWhere(['!=', 'Status', 6])
                ->all();

            foreach ($team as $mates) {

                // $file_name = strtoupper(sha1($mates->ICNO));
                $todays = TblRekod::TodayAtt($mates->ICNO);
                $onleave = TblRekod::DisplayCuti($mates->ICNO, date('Y-m-d'));

                $attRecord[] = [
                    'id' => "$mates->COOldID",
                    'name' => $mates->CONm,
                    'serv' => $mates->servicestatus->ServStatusNm,
                    'designation' => $mates->jawatan->nama,
                    'timeIn' => $todays ? $todays->formatTimeIn : '--:--',
                    'timeOut' => $todays ? $todays->formatTimeOut : '--:--',
                    'onleave' => $onleave ? $onleave : '-',
                    // 'pic' => "https://hronline.ums.edu.my/picprofile/picstf/$file_name.jpeg",
                ];
            }

            $data = [
                // 'deptId' => $staff->DeptId,
                'day' => date('d'),
                'month' => date('m'),
                'year' => date('Y'),
                'totalStaff' => count($team),
                'teammates' => $attRecord,
            ];

            return $data;
        }
    }
    public function actionTeam()
    {
        // echo 'd';die;
        if ($params = $_REQUEST) {

            $data = [];
            $attRecord = [];
            $icno = $params['icno'];
            $staff = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
            $dept = Department::findOne(['chief' => $icno]);
            $Serv = ServiceStatus::findOne(['ServStatusCd' => $staff->statLantikan]);

            // var_dump($dept);
            $skb = false;

            if ($dept) {
                $team = Tblprcobiodata::find()
                    ->where(['DeptId' => $staff->DeptId,])
                    // ->where(['IN', 'ICNO', $data])
                    ->andWhere(['!=', 'Status', 6])
                    ->orderBy([
                        'DeptId' => SORT_ASC,
                    ])
                    ->all();
                $peg = $team;
                foreach ($peg as $p) {
                    $data[] = $p->ICNO;
                }
            } else {

                $peg = SetPegawai::find()->where(['pelulus_icno' => $icno])->all();
                if (!$peg) {
                    $peg = SetPegawai::find()->where(['peraku_icno' => $icno])->andWhere(['!=', 'peraku_icno', ''])->all();
                }
                foreach ($peg as $p) {
                    $data[] = $p->pemohon_icno;
                }
            }
            $team = Tblprcobiodata::find()
                // ->where(['DeptId' => $staff->DeptId,])
                ->where(['IN', 'ICNO', $data])
                ->andWhere(['!=', 'Status', 6])
                ->orderBy([
                    'campus_id' => SORT_ASC,
                    'CONm' => SORT_ASC,
                ])
                ->all();
            
            foreach ($team as $mates) {

                // $file_name = strtoupper(sha1($mates->ICNO));
                $todays = TblRekod::TodayAtt($mates->ICNO);
                if ($staff->DeptId == 2) {
                    $todays = KeselamatanTblRekod::TodayAtt($mates->ICNO);
                }
                $onleave = TblRekod::DisplayCuti($mates->ICNO, date('Y-m-d'));

                $attRecord[] = [
                    'id' => "$mates->ICNO",
                    'name' => $mates->CONm,
                    'designation' => $mates->jawatan->gred,
                    'timeIn' => $todays ? $todays->formatTimeIn : '--:--',
                    'timeOut' => $todays ? $todays->formatTimeOut : '--:--',
                    'onleave' => $onleave ? $onleave : '-',
                    'serv' => $mates->Status,

                    // 'pic' => "https://hronline.ums.edu.my/picprofile/picstf/$file_name.jpeg",
                ];
            }

            $data = [
                // 'deptId' => $staff->DeptId,
                'day' => date('d'),
                'month' => date('m'),
                'year' => date('Y'),
                'icno' => $icno,
                'skb'=>$skb,
                'totalStaff' => count($team),
                'teammates' => $attRecord,
            ];

            return $data;
        }
    }
    public function actionCount()
    {
        // echo 'd';die;
        if ($params = $_REQUEST) {

            $data = [];

            $icno = $params['icno'];
            $staff = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
            $dept = Department::findOne(['chief' => $icno]);

            // var_dump($dept);
            if ($dept) {
                $team = Tblprcobiodata::find()
                    ->where(['DeptId' => $staff->DeptId,])
                    // ->where(['IN', 'ICNO', $data])
                    ->andWhere(['!=', 'Status', 6])
                    ->all();
                $peg = $team;
                foreach ($peg as $p) {
                    $data[] = $p->ICNO;
                }
            } else {

                // $peg = SetPegawai::find()->where(['pelulus_icno' => $icno])->all();
                // if (!$peg) {
                    $peg = SetPegawai::find()->where(['!=', 'peraku_icno', ''])->andWhere(['or',
                    ['peraku_icno'=>$icno],
                    ['pelulus_icno'=>$icno]
                ])->all();
                // }
                foreach ($peg as $p) {
                    $data[] = $p->pemohon_icno;
                }
            }
            $team = Tblprcobiodata::find()
                // ->where(['DeptId' => $staff->DeptId,])
                ->where(['IN', 'ICNO', $data])
                ->andWhere(['!=', 'Status', 6])
                ->orderBy([
                    'DeptId' => SORT_ASC,
                ])
                ->all();
            $model = TblRecords::find()->where(['IN', 'icno', $data])->andWhere(['<=', 'start_date', date('Y-m-d')])->andWhere(['>=', 'end_date', date('Y-m-d')])->all();
            $wfh = TblWfh::find()->where(['IN', 'icno', $data])->andWhere(['<=','start_date', date('Y-m-d')])->andWhere(['>=','end_date', date('Y-m-d')])->all();
            // $end_sql = 'SELECT * FROM attendance.tbl_wfh WHERE icno=:icno AND (:date BETWEEN start_date AND end_date)';
            // $wfh = TblRecords::findBySql($end_sql, [':icno' => $icno, ':date' => date('Y-m-d')])->all();
    
            $todays = TblRekod::find()->where(['IN', 'icno', $data])->andWhere(['tarikh' => date('Y-m-d')])->all();



            $data = [
                'deptId' => $staff->DeptId,
                'day' => date('d'),
                'month' => date('m'),
                'year' => date('Y'),
                'totalStaff' => count($model), //jumlah bercuti
                'wfh' => count($wfh),
                'todays' => count($todays),
                'team' => count($team),
            ];

            return $data;
        }
    }
}
