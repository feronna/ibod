<?php

namespace app\commands;

use app\models\keselamatan\TblShiftKeselamatan;
use app\models\keselamatan\TblOt;
use app\models\keselamatan\TblLmt;
use app\models\w_letter\TblPermohonan;
use app\models\w_letter\RefKategoriJabatan;
use app\models\w_letter\LogAttempt;
use app\models\Notification;
use yii\console\Controller;
use yii\console\ExitCode;
use app\models\umsshield\SelfRisk;
use app\models\hronline\Tblprcobiodata;
use DateTime;

class WLetterController extends Controller {

//    public function actionEsuratKeselamatan() {
//
//        $shift = TblShiftKeselamatan::find()->where(['tarikh' => date('Y-m-d')])->all();
//
//        foreach ($shift as $shift) {
//            if ($this->ExistApplication($shift) == FALSE) {
//                $this->Apply($shift);
//            }
//        }
//
//        $ot = TblOt::find()->where(['tarikh' => date('Y-m-d')])->all();
//
//        foreach ($ot as $ot) {
//            if ($this->ExistApplication($ot) == FALSE) {
//                $this->Apply($ot);
//            }
//        }
//
//        $lmt = TblLmt::find()->where(['tarikh' => date('Y-m-d')])->all();
//
//        foreach ($lmt as $lmt) {
//            if ($this->ExistApplication($lmt) == FALSE) {
//                $this->Apply($lmt);
//            }
//        }
//
//        return ExitCode::OK;
//    }
//
//    public function Apply($user) {
//
//        $ic = $user->icno;
//
//        $model = new TblPermohonan();
//        $model->ICNO = $ic;
//        $model->tugas = "Menjalankan tugas Bahagian Keselamatan";
//        $model->tarikh_mohon = date('Y-m-d');
//        $model->status_semasa = 3;
//        $model->status_notifikasi = 1;
//        $model->tarikh_notifikasi = date("Y-m-d H:i:s");
//        $model->isActive = 1;
//        $model->StartDate = date('Y-m-d');
//        $model->EndDate = date('Y-m-d');
//        $model->auto = 1;
//        $model->auto_desc = "BAHAGIAN KESELAMATAN";
//        $model->kategori = "E100";
//
//        $risk = SelfRisk::find()->where(['icno' => $ic])->orderBy(['assessmentTaken' => SORT_DESC])->One();
//
//        if ($risk) { //sdh ambil assessment
//            if ($risk->riskGroupId == 2 || $risk->riskGroupId == 3) {
//                $log = new LogAttempt();
//                $log->ICNO = $ic;
//                $log->desc = "SELF-RISK STATUS RED";
//                $log->datetime = date("Y-m-d H:i:s");
//                $log->save(false);
//            } else {
//                $model->save(false);
//
//                $ntf = new Notification();
//                $ntf->icno = $ic;
//                $ntf->title = "Surat Kebenaran Bekerja";
//                $ntf->content = 'Surat Kebenaran Bekerja (COVID-19). Menunggu tindakan anda. Sila klik <a class="btn btn-primary btn-sm" href="/staff/web/w-letter/pemohon">disini</a>';
//                $ntf->ntf_dt = date('Y-m-d H:i:s');
//                $ntf->save();
//            }
//        }else {
//            $log = new LogAttempt();
//            $log->ICNO = $ic;
//            $log->desc = "SELF-RISK STATUS NOT FOUND";
//            $log->datetime = date("Y-m-d H:i:s");
//            $log->save(false);
//        }
//    }
//
//    public function ExistApplication($user) {
//
//        if (TblPermohonan::find()->where(['ICNO' => $user->icno])->andWhere(['StartDate' => $user->tarikh])->one()) {
//            return TRUE;
//        } else {
//            return FALSE;
//        }
//    }
//    public function actionBatalEsuratWfo() {
//        $model = TblPermohonan::find()->where(['StartDate' => date("Y-m-d")])->andWhere(['auto'=>1])->all();
//        foreach ($model as $model) {
//            $wfh = \app\models\kehadiran\TblWfh::find()->where(['icno' => $model->ICNO])->andWhere(['start_date' => date("Y-m-d")])->one();
//
//            if ($wfh) {
//                $model->delete();
//            }
//        }
//        
//        return ExitCode::OK;
//    }
//
//    public function actionEsuratWfo() {
//
//        // $date = new DateTime('Y-m-d');
//        $date = new DateTime();
//        $date->modify('+1 day');
//
//        $wfo = array();
//        $model = Tblprcobiodata::find()->where(['!=', 'Status', 6])->all();
//        foreach ($model as $model) {
//            $wfh = \app\models\kehadiran\TblWfh::find()->where(['icno' => $model->ICNO])->andWhere(['start_date' => $date->format('Y-m-d')])->all();
//
//            if (empty($wfh)) {
//                $wfo[] = $model->ICNO;
//            }
//        }
//
//        foreach ($wfo as $wfo) {
//            if ($this->ExistApplicationWfo($wfo) == FALSE) {
//                $this->ApplyWfo($wfo);
//            }
//        }
//
//
//        return ExitCode::OK;
//    }
//
//    public function ExistApplicationWfo($user) {
//        $date = new DateTime();
//        $date->modify('+1 day');
//        if (TblPermohonan::find()->where(['ICNO' => $user])->andWhere(['StartDate' => $date->format('Y-m-d')])->one()) {
//            return TRUE;
//        } else {
//            return FALSE;
//        }
//    }
//
//    public function ApplyWfo($icno) {
//        $user = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
//        $date = new DateTime();
//        $date->modify('+1 day');
//        $datewfo = $date->format('Y-m-d');
//        $cat = RefKategoriJabatan::findOne(['DeptId' => $user->DeptId]);
//
//        $ic = $user->ICNO;
//
//        $model = new TblPermohonan();
//        $model->ICNO = $ic;
//        $model->tugas = "Menjalankan tugas di kawasan pejabat.";
//        $model->tarikh_mohon = date("Y-m-d H:i:s");
//        $model->status_semasa = 3;
//        $model->status_notifikasi = 1;
//        $model->tarikh_notifikasi = date("Y-m-d H:i:s");
//        $model->isActive = 1;
//        $model->StartDate = $datewfo;
//        $model->EndDate = $datewfo;
//        $model->auto = 1;
//        $model->auto_desc = "BAHAGIAN SUMBER MANUSIA";
//        if ($cat) {
//            $model->kategori = $cat->kategori;
//        } else {
//            $model->kategori = "NE50";
//        }
//
//        $risk = SelfRisk::find()->where(['icno' => $ic])->orderBy(['assessmentTaken' => SORT_DESC])->One();
//
//        if ($risk) { //sdh ambil assessment
//            if ($risk->riskGroupId == 2 || $risk->riskGroupId == 3) {
//                $log = new LogAttempt();
//                $log->ICNO = $ic;
//                $log->desc = "SELF-RISK STATUS RED";
//                $log->datetime = date("Y-m-d H:i:s");
//                $log->save(false);
//            } else {
//                $model->save(false);
//
//                $ntf = new Notification();
//                $ntf->icno = $ic;
//                $ntf->title = "Surat Kebenaran Bekerja";
//                $ntf->content = 'Surat Kebenaran Bekerja (COVID-19). Menunggu tindakan anda. Sila klik <a class="btn btn-primary btn-sm" href="/staff/web/w-letter/pemohon">disini</a>';
//                $ntf->ntf_dt = date('Y-m-d H:i:s');
//                $ntf->save();
//            }
//        } else {
//            $log = new LogAttempt();
//            $log->ICNO = $ic;
//            $log->desc = "SELF-RISK STATUS NOT FOUND";
//            $log->datetime = date("Y-m-d H:i:s");
//            $log->save(false);
//        }
//    }

}
