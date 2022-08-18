<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\cuti\Layak;
use app\models\cuti\SetPegawai;
use app\models\cuti\TblRecords;
use app\models\system_core\TblDahsboard;
use app\models\hronline\Tblprcobiodata;
use app\models\kehadiran\TblWfh;
use app\models\system_core\TblPendingTaskcommand;
use app\models\system_core\TblPendingtask;
use app\models\myidp\RptStatistikIdpV2;
use app\models\system_core\TblDashboardInfo;

class DashboardController extends Controller
{



    // public function actionDashboardinfopr()
    // {

    //     $pegawai = SetPegawai::find()->where(['set_status' => 1])->andWhere(['!=','peraku_icno',''])->all();
    //     // var_dump($pegawai);die;
    //     foreach ($pegawai as $p) {
    //         $model = TblDashboardInfo::find()->where(['icno' => $p->peraku_icno])->exists();
    //         if (!$model) {

    //             $new = new TblDashboardInfo();
    //             $new->icno = $p->peraku_icno;
    //             $new->flag = 0;
    //             $new->save(false);
    //         }
    //     }
    //     return ExitCode::OK;
    // }
    // public function actionDashboardinfopl()
    // {

    //     $pegawai = SetPegawai::find()->where(['set_status' => 1])->all();
    //     // var_dump($pegawai);die;
    //     foreach ($pegawai as $p) {
    //         $model = TblDashboardInfo::find()->where(['icno' => $p->pelulus_icno])->exists();
    //         if (!$model) {

    //             $new = new TblDashboardInfo();
    //             $new->icno = $p->pelulus_icno;
    //             $new->flag = 1;

    //             $new->save(false);
    //         }
    //     }
    //     return ExitCode::OK;
    // }
    // //count staff on leave on the date , under the "ICNO" supervision
    // public function actionCountCuti()
    // {
    //     $info = TblDashboardInfo::find()->where(['flag'=>0])->all();
    //     $date = date('Y-m-d');
    //     foreach ($info as $i) {
    //         $data = [];

    //         $peg = SetPegawai::find()->where(['peraku_icno'=>$i->icno])->andWhere(['!=','peraku_icno',''])->all();
    //         foreach($peg as $p){
    //             $data[] = $p->pemohon_icno;                
    //         }
         
    //         $model = TblRecords::find()->where(['IN','icno',$data])->andWhere(['<=','start_date',$date])->andWhere(['>=','end_date',$date])->all();
         
    //         $add = TblDashboardInfo::findOne(['icno' => $i->icno,'flag'=>0]);

    //         if (!$model) {
    //             $add->count1 = 0;
    //             $add->name = "Staff on Leave Today";
    //             $add->url1 = '<a class="btn btn-primary btn-sm" href="/staff/web/kehadiran/pantau-kehadiran">disini</a>';
    //             $add->date = date('Y-m-d');
    //             $add->save(false);
    //         } else {

    //             $add->name = "Staff on Leave Today";
    //             $add->url1 = '<a class="btn btn-primary btn-sm" href="/staff/web/kehadiran/pantau-kehadiran">disini</a>';
    //             $add->date = date('Y-m-d');

    //             $add->count1 = count($model);
    //             $add->save(false);
    //         }
    //     }
    //     return ExitCode::OK;
    // }
    // public function actionCountCutiPl()
    // {
    //     $info = TblDashboardInfo::find()->where(['flag'=>1])->all();
    //     $date = date('Y-m-d');
    //     foreach ($info as $i) {
    //         $data = [];

    //         $peg = SetPegawai::find()->where(['pelulus_icno'=>$i->icno])->all();
    //         foreach($peg as $p){
    //             $data[] = $p->pemohon_icno;                
    //         }
         
    //         $model = TblRecords::find()->where(['IN','icno',$data])->andWhere(['<=','start_date',$date])->andWhere(['>=','end_date',$date])->all();
         
    //         $add = TblDashboardInfo::findOne(['icno' => $i->icno,'flag'=>1]);

    //         if (!$model) {
    //             $add->count1 = 0;
    //             $add->name = "Staff on Leave Today";
    //             $add->url1 = '<a class="btn btn-primary btn-sm" href="/staff/web/kehadiran/pantau-kehadiran">disini</a>';
    //             $add->date = date('Y-m-d');
    //             $add->save(false);
    //         } else {

    //             $add->name = "Staff on Leave Today";
    //             $add->url1 = '<a class="btn btn-primary btn-sm" href="/staff/web/kehadiran/pantau-kehadiran">disini</a>';
    //             $add->date = date('Y-m-d');

    //             $add->count1 = count($model);
    //             $add->save(false);
    //         }
    //     }
    //     return ExitCode::OK;
    // }
    // public function actionCountwfh()
    // {
    //     $info = TblDashboardInfo::find()->all();
    //     $date = date('Y-m-d');
    //     foreach ($info as $i) {
    //         $data = [];

    //         $peg = SetPegawai::find()->where(['peraku_icno'=>$i->icno])->all();
    //         foreach($peg as $p){
    //             $data[] = $p->pemohon_icno;                
    //         }
         
    //         $model = TblWfh::find()->where(['IN','icno',$data])->andWhere(['start_date'=>$date])->all();
    //         // $model = TblWfh::findOne([''])
    //         $add = TblDashboardInfo::findOne(['icno' => $i->icno]);
    //         // $this->Notification($model->ganti_by, 'Cuti', 'Permohonan Cuti Oleh ' . "$bio->CONm" . ', ' . $model->full_date . ' Menunggu Persetujuan Anda . Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/individu/ganti"></a> untuk membuat tindakan');

    //         if (!$model) {
    //             $add->count2 = 0;
    //             $add->name = "Staff WFH Today";
    //             $add->url2 = '<a class="btn btn-primary btn-sm" href="/staff/web/kehadiran/pantau-kehadiran">disini</a>';
    //             $add->date = date('Y-m-d');
    //             $add->save(false);
    //         } else {

    //             $add->name2 = "Staff WFH Today";
    //             $add->url2 = '<a class="btn btn-primary btn-sm" href="/staff/web/kehadiran/pantau-kehadiran">disini</a>';
    //             $add->date = date('Y-m-d');

    //             $add->count2 = count($model);
    //             $add->save(false);
    //         }
    //     }
    //     return ExitCode::OK;
    // }
    // public function actionCountwfhpl()
    // {
    //     $info = TblDashboardInfo::find()->all();
    //     $date = date('Y-m-d');
    //     foreach ($info as $i) {
    //         $data = [];

    //         $peg = SetPegawai::find()->where(['pelulus_icno'=>$i->icno])->all();
    //         foreach($peg as $p){
    //             $data[] = $p->pemohon_icno;                
    //         }
         
    //         $model = TblWfh::find()->where(['IN','icno',$data])->andWhere(['start_date'=>$date])->all();
    //         // $model = TblWfh::findOne([''])
    //         $add = TblDashboardInfo::findOne(['icno' => $i->icno]);
    //         // $this->Notification($model->ganti_by, 'Cuti', 'Permohonan Cuti Oleh ' . "$bio->CONm" . ', ' . $model->full_date . ' Menunggu Persetujuan Anda . Sila Klik <a class="btn btn-primary btn-sm" href="/staff/web/cuti/individu/ganti"></a> untuk membuat tindakan');

    //         if (!$model) {
    //             $add->count2 = 0;
    //             $add->name = "Staff WFH Today";
    //             $add->url2 = '<a class="btn btn-primary btn-sm" href="/staff/web/kehadiran/pantau-kehadiran">disini</a>';
    //             $add->date = date('Y-m-d');
    //             $add->save(false);
    //         } else {

    //             $add->name2 = "Staff WFH Today";
    //             $add->url2 = '<a class="btn btn-primary btn-sm" href="/staff/web/kehadiran/pantau-kehadiran">disini</a>';
    //             $add->date = date('Y-m-d');

    //             $add->count2 = count($model);
    //             $add->save(false);
    //         }
    //     }
    //     return ExitCode::OK;
    // }
    public function actionTbldata()
    {
        $counter = 0;
        $model = Tblprcobiodata::find()->where(['!=', 'Status', 6])->all();

        foreach ($model as $m) {
            $data = TblDahsboard::find()->where(['icno' => $m->ICNO])->exists() ?
                TblDahsboard::find()->where(['icno' => $m->ICNO])->one() :
                new TblDahsboard(['icno' => $m->ICNO]);

            //idp
            $idprpt = \app\models\myidp\RptStatistikIdp::find()->where(['tahun' => date('Y'), 'icno' => $m->ICNO])->one();
            $minidp = $idprpt ? $idprpt->idp_mata_min : 0;
            $markahidp = $idprpt ? $idprpt->jum_mata_dikira : 0;
            $data->idp = $markahidp . ' / ' . $minidp;
            $data->percentageidp = $minidp == 0 ? 100 : round($markahidp / $minidp * 100);

            //klinik
            $klinik = \app\models\klinikpanel\Tblmaxtuntutan::find()->where(['max_icno' => $m->ICNO])->one();
            if ($klinik) {
                $data->klinikpanel = $klinik->current_balance;
                $data->total_klinikpanel = $klinik->max_tuntutan;
                if ($klinik->max_tuntutan > 0) {
                    $data->percentageklinik = $klinik->current_balance / $klinik->max_tuntutan * 100;
                }
            }

            //cuti
            $total = Layak::getBakiLatest($m->ICNO);
            $model_layak = Layak::getLatestLayak($m->ICNO);
            $total_layak = $model_layak ? $model_layak->layak_cuti + $model_layak->layak_bawa_lepas : 0;
            $data->cuti = $total . ' / ' . $total_layak;
            $data->percentagecuti = $total_layak == 0 ? 0 : $total / $total_layak * 100;

            //lastupdate
            $data->bio_lastupdate = date("d-m-Y", strtotime($m->last_update));

            //keluarga
            $data->bio_keluarga = \app\models\hronline\Tblkeluarga::jumlahkeluarga($m->ICNO);

            //pendidikan
            $data->bio_pendidikan = $m->displayPendidikan;

            //passport
            $exp = \app\models\hronline\Tblpasport::expirydate($m->ICNO);
            $data->bio_passport = $exp ? date("d-m-Y", strtotime($exp)) : $exp;

            //lesen
            $exl = \app\models\hronline\Tbllesen::expirydate($m->ICNO);
            $data->bio_lesen = $exl ? date("d-m-Y", strtotime($exl)) : $exl;
            
            if ($data->save(false)){
                $counter = $counter + 1;
                date_default_timezone_set("Asia/Kuala_Lumpur");
                $data->tarikh_kemaskini = date('Y-m-d H:i:s');    
                $data->save(false);      
            } 
            
        }

        echo $counter.' staffs data updated.';
        return ExitCode::OK;
    }

    public function actionTblpendingtask()
    {
        $model = TblPendingTaskcommand::find()->all();

        foreach ($model as $m) {
            $biodata = Tblprcobiodata::find()->where(['!=', 'Status', 6])->all();

            foreach ($biodata as $b) {
                $icno = $b->ICNO;
                $model = TblPendingtask::find()->where(['command_id' => $m->id, 'icno' => $icno])->exists() ?
                    TblPendingtask::find()->where(['command_id' => $m->id, 'icno' => $icno])->one() :
                    new TblPendingtask(['command_id' => $m->id, 'icno' => $icno]);
                $model->name = $m->name;
                $model->url = $m->url;
                try {
                    $model->count = eval('return ' . $m->command);
                } catch (\Exception $e) {
                }
                $model->status = 1;
                $model->icon = $m->icon;
                if ($model->count > 0) {
                    $model->save(false);
                } else {
                    $model->delete();
                }
            }
        }
        return ExitCode::OK;
    }

    public function actionPendingTaskIndividu($icno, $id = null)
    {
        $model = TblPendingTaskcommand::find();
        $id ? $model->where(['id' => $id]) : '';
        foreach ($model->all() as $m) {

            $model = TblPendingtask::find()->where(['command_id' => $m->id, 'icno' => $icno])->exists() ?  TblPendingtask::find()->where(['command_id' => $m->id, 'icno' => $icno])->one() : new TblPendingtask(['command_id' => $m->id, 'icno' => $icno]);
            $model->name = $m->name;
            $model->url = $m->url;
            try {
                $model->count = eval('return ' . $m->command);
            } catch (\Exception $e) {
            }
            $model->status = 1;
            $model->icon = $m->icon;

            if ($model->count > 0) {
                $model->save(false);
            } else {
                $model->delete();
            }
        }
        return ExitCode::OK;
    }
}
