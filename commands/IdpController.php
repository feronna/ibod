<?php

namespace app\commands;

use yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\console\ExitCode;
use yii\console\Controller;
use app\models\Notification;
use app\models\myidp\IdpMata;
use app\models\myidp\Peserta;
use app\models\myidp\IdpMataV2;
use app\models\myidp\Kehadiran;
use app\models\myidp\TblMonths;
use app\models\myidp\RefCpdGroup;
use app\models\myidp\SiriLatihan;
use app\models\myidp\SlotLatihan;
use app\models\myidp\VCpdLatihan;
use app\models\myidp\IdpStatistik;
use app\models\hronline\Department;
use app\models\myidp\KehadiranSiri;
use app\models\myidp\KursusLatihan;
use app\models\myidp\KehadiranJfpiu;
use app\models\myidp\MohonKursusLama;
use app\models\myidp\RptStatistikIdp;
use app\models\hronline\TblPenempatan;
use app\models\myidp\SiriLatihanJfpiu;
use app\models\myidp\SlotLatihanJfpiu;
use app\models\hronline\Tblprcobiodata;
use app\models\myidp\PermohonanLatihan;
use app\models\myidp\RptStatistikIdpV2;
use app\models\hronline\Kumpulankhidmat;
use app\models\myidp\KursusLatihanJfpiu;
use app\models\myidp\VCpdSenaraiLatihan;
use app\models\hronline\Tblrscosandangan;
use app\models\myidp\IdpStatistikJabatan;
use app\models\myidp\StatistikKursusLuar;
use app\models\myidp\IdpStatistikAkademik;
use app\models\myidp\PermohonanKursusLuar;
use app\models\myidp\BorangPenilaianLatihan;
use app\models\myidp\RefCpdGroupGredJawatan;
use app\models\myidp\IdpStatistikPentadbiran;
use app\models\myidp\StatistikPermohonanMata;
use app\models\myidp\StatistikSkimPentadbiran;
use app\models\myidp\PermohonanMataIdpIndividu;
use app\models\myidp\StatistikKursusDalamanByBulan;
use app\models\myidp\StatistikKursusDalamanByKehadiran;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class IdpController extends Controller
{

    public function actionAutoAddStaff()
    {
        $currentYear = date('Y');
        $checks = Tblprcobiodata::find()->where(['<>', 'Status', '6'])->all();

        foreach ($checks as $checks) {

            /** check gredJawatan perlu IDP atau tidak (by tahun)***/
            $gredj = $checks->jawatan->gred;

            $modelcpdgroupgj = RefCpdGroupGredJawatan::find()->where(['gred' => $gredj, 'tahun' => $currentYear])->one();

            if (!$modelcpdgroupgj) {
                $statusIDP = '6';
                $statusIDP2 = '6';
            } else {

                if ($checks->jawatan->isKhas == '1') {
                    $statusIDP = '5';
                    $statusIDP2 = '5';
                } else {
                    if ($checks->jawatan->job_category == '2') { //pentadbiran
                        if (
                            $checks->statLantikan == '2' || //Lantikan Sementara
                            $checks->statLantikan == '6' || //Lantikan Pekerja Sambilan Harian
                            $checks->statLantikan == '7' || //Lantikan Kontrak Jabatan
                            $checks->statLantikan == '51' || //Lantikan Pinjaman
                            $checks->statLantikan == '52'
                        ) { //Lantikan Dipinjamkan
                            $statusIDP = '5';
                            $statusIDP2 = '5';
                        } elseif ($checks->statLantikan == '1' || $checks->statLantikan == '3') { //Lantikan Tetap / Lantikan Kontrak
                            if ($checks->Status == '1') { //Aktif

                                if (date_create($checks->startDateStatus)->format("Y") == $currentYear) {
                                    $dateStart = date_create($checks->startDateStatus);
                                    $dateEndYear = date_create($currentYear . "-12-31");
                                    //date_diff() function calculate the difference two dates
                                    $dateDuration = date_diff($dateStart, $dateEndYear);
                                    //format the date difference
                                    $dateDuration2 = $dateDuration->format('%a');

                                    if ($dateDuration2 >= 181) { //previous, 182 => 2 July, change to 181 because better start with 1 July
                                        $statusIDP2 = '1';
                                    } elseif ($dateDuration2 >= 91 && $dateDuration2 < 181) {
                                        $statusIDP2 = '2';
                                    } elseif ($dateDuration2 < 91) {
                                        $statusIDP2 = '3';
                                    }
                                } else {
                                    $statusIDP2 = '1';
                                }

                                $statusIDP = '1';
                            } else {
                                $statusIDP = '7';
                                $statusIDP2 = '7'; //tidak aktif bergaji penuh & statLantikan tetap
                            }
                        }
                    } else {

                        //akademik
                        if ($checks->statLantikan == '1' || $checks->statLantikan == '2' || $checks->statLantikan == '3') {
                            if ($checks->Status == '1') {

                                if (date_create($checks->startDateStatus)->format("Y") == $currentYear) {
                                    $dateStart = date_create($checks->startDateStatus);
                                    $dateEndYear = date_create($currentYear . "-12-31");
                                    //date_diff() function calculate the difference two dates
                                    $dateDuration = date_diff($dateStart, $dateEndYear);
                                    //format the date difference
                                    $dateDuration2 = $dateDuration->format('%a');

                                    if ($dateDuration2 >= 182) {
                                        $statusIDP2 = '1';
                                    } elseif ($dateDuration2 >= 91 && $dateDuration2 < 182) {
                                        $statusIDP2 = '2';
                                    } elseif ($dateDuration2 < 91) {
                                        $statusIDP2 = '3';
                                    }
                                } else {
                                    $statusIDP2 = '1';
                                }

                                $statusIDP = '1';
                            } else {
                                $statusIDP = '7';
                                $statusIDP2 = '7'; //tidak aktif bergaji penuh & statLantikan tetap
                            }
                        } else {
                            $statusIDP = '5';
                            $statusIDP2 = '5';
                        }
                    }
                }
            }

            $modelB = IdpMata::find()
                ->where(['staffID' => $checks->ICNO])
                ->andWhere(['tahun' => $currentYear])
                ->one();

            if (!$modelB) {
                $modelB = new IdpMata();
                $modelB->staffID = $checks->ICNO;
                $modelB->tahun = $currentYear;
                $modelB->status = $checks->Status;
                $modelB->statusIDP = $statusIDP;
                $modelB->statusIDP2 = $statusIDP2;
                $modelB->tarikhKemaskini = date('Y-m-d H:i:s');
                $modelB->save(false);
            } else {
                $modelB->status = $checks->Status;
                $modelB->statusIDP = $statusIDP;
                $modelB->statusIDP2 = $statusIDP2;
                $modelB->tarikhKemaskini = date('Y-m-d H:i:s');
                $modelB->save(false);
            }

            if ($modelB->save(false)) {

                $modelBBB = RptStatistikIdp::find()
                    ->where(['icno' => $modelB->staffID])
                    ->andWhere(['tahun' => $currentYear])
                    ->one();

                if (!$modelBBB) {
                    $modelBBB = new RptStatistikIdp();
                    $modelBBB->icno = $modelB->staffID;
                    $modelBBB->tahun = date('Y');
                    $modelBBB->staf_status = $modelB->status;
                    $modelBBB->statusIDP = $modelB->statusIDP;
                    $modelBBB->statusIDP2 = $modelB->statusIDP2;
                    $modelBBB->tarikh_kemaskini = date('Y-m-d H:i:s');
                    $modelBBB->save(false);
                } else {
                    $modelBBB->staf_status = $modelB->status;
                    $modelBBB->statusIDP = $modelB->statusIDP;
                    $modelBBB->statusIDP2 = $modelB->statusIDP2;
                    $modelBBB->tarikh_kemaskini = date('Y-m-d H:i:s');
                    $modelBBB->save(false);
                }
            }

            $modelBB = IdpMataV2::find()
                ->where(['staffID' => $checks->ICNO])
                ->andWhere(['tahun' => $currentYear])
                ->one();

            if (!$modelBB) {
                $modelBB = new IdpMataV2();
                $modelBB->staffID = $checks->ICNO;
                $modelBB->tahun = $currentYear;
                $modelBB->status = $checks->Status;
                $modelBB->statusIDP = $statusIDP;
                $modelBB->statusIDP2 = $statusIDP2;
                $modelBB->save(false);
            } else {
                $modelBB->status = $checks->Status;
                $modelBB->statusIDP = $statusIDP;
                $modelBB->statusIDP2 = $statusIDP2;
                $modelBB->save(false);
            }

            if ($modelBB->save(false)) {

                $modelBBBB = RptStatistikIdpV2::find()
                    ->where(['icno' => $modelBB->staffID])
                    ->andWhere(['tahun' => $currentYear])
                    ->one();

                if (!$modelBBBB) {
                    $modelBBBB = new RptStatistikIdpV2();
                    $modelBBBB->icno = $modelBB->staffID;
                    $modelBBBB->tahun = $currentYear;
                    $modelBBBB->staf_status = $modelBB->status;
                    $modelBBBB->statusIDP = $modelBB->statusIDP;
                    $modelBBBB->statusIDP2 = $modelBB->statusIDP2;
                    $modelBBBB->tarikh_kemaskini = date('Y-m-d H:i:s');
                    $modelBBBB->save(false);
                } else {
                    $modelBBBB->staf_status = $modelBB->status;
                    $modelBBBB->statusIDP = $modelBB->statusIDP;
                    $modelBBBB->statusIDP2 = $modelBB->statusIDP2;
                    $modelBBBB->tarikh_kemaskini = date('Y-m-d H:i:s');
                    $modelBBBB->save(false);
                }
            }
        }

        echo '1';

        return ExitCode::OK;
    }

    public function actionAutoRedirect() //auto-redirect to PP 
    {
        //get current year
        $currentYear = date('Y');

        $check = PermohonanMataIdpIndividu::find()
            ->where("SUBSTRING(tarikhPohon,1,4) = $currentYear and statusPermohonan = '1'")
            ->all();

        $count = 0;
        foreach ($check as $check) {

            $dateAfter = date_create($check->tarikhPohon);
            $dateAfter2 = date_add($dateAfter, date_interval_create_from_date_string("3 days"));
            $dateAfter3 = date_format($dateAfter2, "Y-m-d");

            $currentDate = date('Y-m-d');

            if ($currentDate > $dateAfter3) {

                $count++;
                $check->statusPermohonan = "9";
                $check->save(false);
            }
        }

        echo $count;

        return ExitCode::OK;
    }

    public function actionUpdateSandanganPenempatan()
    {
        $currentYear = date('Y');
        $previousYear = date("Y", strtotime("-1 year"));
        $previousYear2 = date("Y", strtotime("-2 year"));

        /** check staff current status **/
        $current = IdpMata::find()
            ->where(['tahun' => $currentYear])
            ->all();

        foreach ($current as $current2) {

            $biodataCurrent = Tblprcobiodata::find()
                ->where(['ICNO' => $current2->staffID])
                ->one();

            if ($biodataCurrent) {
                $current2->status = $biodataCurrent->Status;
                $current2->tarikhKemaskini = date('Y-m-d H:i:s');
                $current2->save(false);
            }
        }

        $currentv2 = IdpMataV2::find()
            ->where(['tahun' => $currentYear])
            ->all();

        foreach ($currentv2 as $current2) {

            $biodataCurrent = Tblprcobiodata::find()
                ->where(['ICNO' => $current2->staffID])
                ->one();

            if ($biodataCurrent) {
                $current2->status = $biodataCurrent->Status;
                $current2->save(false);
            }
        }

        /** check sandangan and penempatan */
        $modelRpt = RptStatistikIdpV2::find()
            ->where(['tahun' => $currentYear])
            ->all();

        foreach ($modelRpt as $model) {

            $modelSandangan = Tblrscosandangan::find()
                ->where(['ICNO' => $model->icno])
                ->orderBy(['start_date' => SORT_DESC])
                ->one();

            if ($modelSandangan) {
                $model->sandangan_id = $modelSandangan->id;
                date_default_timezone_set("Asia/Kuala_Lumpur");
                $model->tarikh_kemaskini = date('Y-m-d H:i:s');
                $model->save(false);
            }

            $modelPenempatan = TblPenempatan::find()
                ->where(['ICNO' => $model->icno])
                ->orderBy(['date_start' => SORT_DESC])
                ->one();

            if ($modelPenempatan) {
                $model->penempatan_id = $modelPenempatan->id;
                date_default_timezone_set("Asia/Kuala_Lumpur");
                $model->tarikh_kemaskini = date('Y-m-d H:i:s');
                $model->save(false);
            }
        }

        $modelRpt2 = RptStatistikIdpV2::find()
            ->where(['tahun' => $previousYear])
            ->all();

        foreach ($modelRpt2 as $model) {

            $modelSandangan = Tblrscosandangan::find()
                ->where(['ICNO' => $model->icno])
                ->andWhere(['<>', 'YEAR(start_date)', $currentYear])
                ->orderBy(['start_date' => SORT_DESC])
                ->one();

            if ($modelSandangan) {
                $model->sandangan_id = $modelSandangan->id;
                date_default_timezone_set("Asia/Kuala_Lumpur");
                $model->tarikh_kemaskini = date('Y-m-d H:i:s');
                $model->save(false);
            }

            $modelPenempatan = TblPenempatan::find()
                ->where(['ICNO' => $model->icno])
                ->andWhere(['<>', 'YEAR(date_start)', $currentYear])
                ->orderBy(['date_start' => SORT_DESC])
                ->one();

            if ($modelPenempatan) {
                $model->penempatan_id = $modelPenempatan->id;
                date_default_timezone_set("Asia/Kuala_Lumpur");
                $model->tarikh_kemaskini = date('Y-m-d H:i:s');
                $model->save(false);
            }
        }

        /** 
        $postsNestedWhere = Post::find()->andWhere([
            'or',
            ['title' => null],
            ['body' => null]
        ])->orWhere([
            'and',
            ['not', ['title' => null]],
            ['body' => null]
        ]);
        // SELECT * FROM post WHERE (title IS NULL OR body IS NULL) OR (title IS NOT NULL AND body IS NULL)
         **/

        $modelRpt3 = RptStatistikIdpV2::find()
            ->where(['tahun' => $previousYear2])
            ->all();

        foreach ($modelRpt3 as $model) {

            $modelSandangan = Tblrscosandangan::find()->andWhere([
                'and',
                ['ICNO' => $model->icno],
                ['NOT', ['YEAR(start_date)' => $currentYear]]
            ])->andWhere([
                'and',
                ['ICNO' => $model->icno],
                ['NOT', ['YEAR(start_date)' => $previousYear]]
            ])->orderBy(['start_date' => SORT_DESC])->one();

            if ($modelSandangan) {
                $model->sandangan_id = $modelSandangan->id;
                date_default_timezone_set("Asia/Kuala_Lumpur");
                $model->tarikh_kemaskini = date('Y-m-d H:i:s');
                $model->save(false);
            }

            $modelPenempatan = TblPenempatan::find()->andWhere([
                'and',
                ['ICNO' => $model->icno],
                ['NOT', ['YEAR(date_start)' => $currentYear]]
            ])->andWhere([
                'and',
                ['ICNO' => $model->icno],
                ['NOT', ['YEAR(date_start)' => $previousYear]]
            ])->orderBy(['date_start' => SORT_DESC])->one();

            if ($modelPenempatan) {
                $model->penempatan_id = $modelPenempatan->id;
                date_default_timezone_set("Asia/Kuala_Lumpur");
                $model->tarikh_kemaskini = date('Y-m-d H:i:s');
                $model->save(false);
            }
        }

        echo "1";

        return ExitCode::OK;
    }

    public function actionAutoUpdateMata()
    {
        $check = IdpMata::find()
            ->where(['tahun' => date('Y')])
            ->all();

        $arrayJenis = array("1", "3", "4", "5", "6");

        foreach ($check as $check) {

            for ($i = 0; $i < count($arrayJenis); $i++) {

                $mataaa = 0;
                $mataaax = 0;

                //                $elektif = SlotLatihan::find()
                //                            ->joinWith('sasaran55')
                //                            ->where(['idp_kehadiran.staffID' => 920131115046])
                //                            ->andWhere(['idp_kehadiran.kategoriKursusID' => $arrayJenis[$i]])
                //                            ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => date('Y')])
                //                            ->all();

                $elektif = Kehadiran::find()
                    ->where(['idp_kehadiran.staffID' => $check->staffID])
                    ->andWhere(['idp_kehadiran.kategoriKursusID' => $arrayJenis[$i]])
                    ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => date('Y')])
                    ->all();

                foreach ($elektif as $mataaxp) {

                    if ($arrayJenis[$i] != 1) {
                        $mataaax = $mataaax + $mataaxp->sasaran9->mataSlot;
                    } elseif ($arrayJenis[$i] == 1) {
                        $mataaax = $mataaax + 1;
                    }
                }

                if ($arrayJenis[$i] != 1) {

                    foreach ($elektif as $mataa) {

                        //                    if($mataa->sasaran4->sasaran3->jenisLatihanID != 'jfpiu'){
                        if ($mataa->sasaran9->sasaran4->sasaran3->jenisLatihanID != 'jfpiu') {

                            $checkBorang = BorangPenilaianLatihan::find()
                                //->where(['siriLatihanID' => $mataa->siriLatihanID])
                                ->where(['siriLatihanID' => $mataa->sasaran9->siriLatihanID])
                                ->andWhere(['pesertaID' => $check->staffID])
                                ->andWhere(['statusBorang' => 2])
                                ->one();

                            //            $checkBorangK = BorangPenilaianKeberkesanan::find()
                            //                    ->where(['pesertaID' => Yii::$app->user->getId()])
                            //                    ->andWhere(['siriLatihanID' => $elektif->siriLatihanID])
                            //                    ->andWhere(['statusBorang' => 2])
                            //                    ->one();

                            if ($checkBorang) {
                                //                            $mataaa = $mataaa + $mataa->mataSlot;
                                $mataaa = $mataaa + $mataa->sasaran9->mataSlot;
                            }
                        } else {
                            $mataaa = $mataaa + $mataa->sasaran9->mataSlot;
                        }
                    }
                } else {

                    foreach ($elektif as $mataa) {
                        $mataaa = $mataaa + 1;
                    }
                }

                $check2 = IdpMataV2::find()
                    ->where(['tahun' => $check->tahun, 'staffID' => $check->staffID])
                    ->one();

                if ($arrayJenis[$i] == 1) {
                    $check->mataUmum = $mataaa;
                } elseif ($arrayJenis[$i] == 3) {
                    $check->mataTeras = $mataaa;
                } elseif ($arrayJenis[$i] == 4) {
                    $check->mataElektif = $mataaa;
                } elseif ($arrayJenis[$i] == 5) {
                    $check->mataTerasUni = $mataaa;
                } elseif ($arrayJenis[$i] == 6) {
                    $check->mataTerasSkim = $mataaa;
                }

                //added on 25/3/2021 because V1 and V2 does not have the same amount of staff
                if ($check2) {
                    if ($arrayJenis[$i] == 1) {
                        $check2->mataUmum = $mataaax;
                    } elseif ($arrayJenis[$i] == 3) {
                        $check2->mataTeras = $mataaax;
                    } elseif ($arrayJenis[$i] == 4) {
                        $check2->mataElektif = $mataaax;
                    } elseif ($arrayJenis[$i] == 5) {
                        $check2->mataTerasUni = $mataaax;
                    } elseif ($arrayJenis[$i] == 6) {
                        $check2->mataTerasSkim = $mataaax;
                    }
                }

                $check->tarikhKemaskini = date('Y-m-d H:i:s');

                $check->save(false);
                if ($check2) {
                    $check2->save(false);
                }
            }
        }

        echo "1";

        return ExitCode::OK;
    }

    public function actionAutoUpdateStatistics()
    {

        /** current year **/

        $check2 = IdpMata::find()
            ->where(['tahun' => date('Y')])
            ->all();

        foreach ($check2 as $check2) {

            $modelB = RptStatistikIdp::find()
                ->where(['icno' => $check2->staffID])
                ->andWhere(['tahun' => date('Y')])
                ->one();

            if (!$modelB) {
                $new2 = new RptStatistikIdp();
                $new2->icno = $check2->staffID;
                $new2->tahun = date('Y');
                $new2->staf_status = $check2->status;
                $new2->statusIDP = $check2->statusIDP;
                $new2->statusIDP2 = $check2->statusIDP2;
                $new2->tarikh_kemaskini = date('Y-m-d H:i:s');
                $new2->save(false);
            } else {
                $modelB->staf_status = $check2->status;
                $modelB->statusIDP = $check2->statusIDP;
                $modelB->statusIDP2 = $check2->statusIDP2;
                $modelB->tarikh_kemaskini = date('Y-m-d H:i:s');
                $modelB->save(false);
            }
        }

        $new = RptStatistikIdp::find()
            ->where(['tahun' => date('Y')])
            ->all();

        foreach ($new as $new) {

            $check = IdpMata::find()
                ->where(['staffID' => $new->icno, 'tahun' => date('Y')])
                ->one();

            $new->idp_mata_teras = $check->mataTeras;
            $new->idp_mata_elektif = $check->mataElektif;
            $new->idp_mata_umum = $check->mataUmum;
            $new->idp_mata_teras_skim = $check->mataTerasSkim;
            $new->idp_mata_teras_uni = $check->mataTerasUni;

            /** calculate min **/
            $model3 = Tblprcobiodata::findOne(['ICNO' => $check->staffID]);

            if ($model3) {
                $gredj = $model3->jawatan->gred;

                $modelcpdgroupgj = RefCpdGroupGredJawatan::find()->where(['gred' => $gredj, 'tahun' => date('Y')])->one();

                if ($modelcpdgroupgj) {

                    $cpdgroup = $modelcpdgroupgj->cpdgroup;
                    $modelcpdgroup = RefCpdGroup::find()->where(['cpdgroup' => $cpdgroup, 'tahun' => date('Y')])->one();

                    //                        if ($new->staf_status == '1' && $new->statusIDP2 == '1'){
                    //                        if ($new->staf_status == '1' && $new->statusIDP2 != '2'){
                    //                            if ($new->staf_status == '1' && $new->statusIDP2 != '3'){
                    if (($new->staf_status == '1' && $new->statusIDP2 == '1') ||
                        ($new->staf_status == '1' && $new->statusIDP2 == '5') ||
                        ($new->staf_status == '1' && $new->statusIDP2 == '6') ||
                        ($new->staf_status == '1' && $new->statusIDP2 == '7')
                    ) {
                        $mataMin = $modelcpdgroup->mataMin;
                        $mataMinTerasUni = $modelcpdgroup->minTerasUni;
                        $mataMinTerasSkim = $modelcpdgroup->minTerasSkim;
                        $mataMinElektif = $modelcpdgroup->minElektif;
                        $mataMinTeras = $modelcpdgroup->minTeras;
                        $mataMinUmum = $modelcpdgroup->minUmum;
                        //}     
                    } elseif (($new->staf_status == '2' && $new->statusIDP2 == '7') ||
                        ($new->staf_status == '3' && $new->statusIDP2 == '7') ||
                        ($new->staf_status == '4' && $new->statusIDP2 == '7')
                    ) {

                        $mataMin = 0;
                        $mataMinTerasUni = 0;
                        $mataMinTerasSkim = 0;
                        $mataMinElektif = 0;
                        $mataMinTeras = 0;
                        $mataMinUmum = 0;
                    } elseif (($new->staf_status == '1' && $new->statusIDP2 == '2')) {

                        if ($modelcpdgroup->mataMin != 0) {
                            $mataMin = round($modelcpdgroup->mataMin / 2, 0);
                        } else {
                            $mataMin = $modelcpdgroup->mataMin;
                        }

                        if ($modelcpdgroup->minTerasUni != 0) {
                            $mataMinTerasUni = round($modelcpdgroup->minTerasUni / 2, 0);
                        } else {
                            $mataMinTerasUni = $modelcpdgroup->minTerasUni;
                        }

                        if ($modelcpdgroup->minTerasSkim != 0) {
                            $mataMinTerasSkim = round($modelcpdgroup->minTerasSkim / 2, 0);
                        } else {
                            $mataMinTerasSkim = $modelcpdgroup->minTerasSkim;
                        }

                        if ($modelcpdgroup->minElektif != 0) {
                            $mataMinElektif = round($modelcpdgroup->minElektif / 2, 0);
                        } else {
                            $mataMinElektif = $modelcpdgroup->minElektif;
                        }

                        if ($modelcpdgroup->minTeras != 0) {
                            $mataMinTeras = round($modelcpdgroup->minTeras / 2, 0);
                        } else {
                            $mataMinTeras = $modelcpdgroup->minTeras;
                        }

                        if ($modelcpdgroup->minUmum != 0) {
                            $mataMinUmum = round($modelcpdgroup->minUmum / 2, 0);
                        } else {
                            $mataMinUmum = $modelcpdgroup->minUmum;
                        }
                    } elseif (($new->staf_status == '1' && $new->statusIDP2 == '3')) {

                        if ($modelcpdgroup->mataMin != 0) {
                            $mataMin = round(round($modelcpdgroup->mataMin / 2, 0) / 2, 0);
                        } else {
                            $mataMin = $modelcpdgroup->mataMin;
                        }

                        if ($modelcpdgroup->minTerasUni != 0) {
                            $mataMinTerasUni = round(round($modelcpdgroup->minTerasUni / 2, 0) / 2, 0);
                        } else {
                            $mataMinTerasUni = $modelcpdgroup->minTerasUni;
                        }

                        if ($modelcpdgroup->minTerasSkim != 0) {
                            $mataMinTerasSkim = round(round($modelcpdgroup->minTerasSkim / 2, 0) / 2, 0);
                        } else {
                            $mataMinTerasSkim = $modelcpdgroup->minTerasSkim;
                        }

                        if ($modelcpdgroup->minElektif != 0) {
                            $mataMinElektif = round(round($modelcpdgroup->minElektif / 2, 0) / 2, 0);
                        } else {
                            $mataMinElektif = $modelcpdgroup->minElektif;
                        }

                        if ($modelcpdgroup->minTeras != 0) {
                            $mataMinTeras = round(round($modelcpdgroup->minTeras / 2, 0) / 2, 0);
                        } else {
                            $mataMinTeras = $modelcpdgroup->minTeras;
                        }

                        if ($modelcpdgroup->minUmum != 0) {
                            $mataMinUmum = round(round($modelcpdgroup->minUmum / 2, 0) / 2, 0);
                        } else {
                            $mataMinUmum = $modelcpdgroup->minUmum;
                        }
                    }

                    if ($new->biodata->jawatan->job_category == 1) {
                        if (($mataMinTeras + $mataMinElektif + $mataMinUmum) > $mataMin) {
                            $mataMinUmum = $mataMinUmum - abs($mataMin - ($mataMinTeras + $mataMinElektif + $mataMinUmum));
                        }
                    } elseif ($new->biodata->jawatan->job_category == 2) {
                        if (($mataMinTerasUni + $mataMinElektif + $mataMinTerasSkim) > $mataMin) {
                            $mataMinElektif = $mataMinElektif - abs($mataMin - ($mataMinTerasUni + $mataMinElektif + $mataMinTerasSkim));
                        }
                    }

                    $new->idp_mata_min = $mataMin;
                    $new->idp_kom_teras_uni = $mataMinTerasUni;
                    $new->idp_kom_teras_skim = $mataMinTerasSkim;
                    $new->idp_kom_elektif = $mataMinElektif;
                    $new->idp_kom_teras = $mataMinTeras;
                    $new->idp_kom_umum = $mataMinUmum;

                    if ($model3->jawatan->job_category == 2) {

                        //                            $minElektif = $modelcpdgroup->minElektif; //fixed data in db
                        //                            $minTerasUniversiti = $modelcpdgroup->minTerasUni;
                        //                            $minTerasSkim = $modelcpdgroup->minTerasSkim;

                        $minElektif = $mataMinElektif; //fixed data in db
                        $minTerasUniversiti = $mataMinTerasUni;
                        $minTerasSkim = $mataMinTerasSkim;

                        if ($check->mataElektif >= $minElektif) {
                            //electiveIDPPoint that are counted
                            $elektifTrue = $minElektif;
                        } else {
                            //electiveIDPPoint that are counted
                            $elektifTrue = $check->mataElektif;
                        }

                        /*             * ************************************************************************ */
                        if ($check->mataTerasUni >= $minTerasUniversiti) {
                            $terasUniTrue = $minTerasUniversiti;
                        } else {
                            $terasUniTrue = $check->mataTerasUni;
                        }

                        /*             * ************************************************************************** */
                        if ($check->mataTerasSkim >= $minTerasSkim) {
                            $terasSkimTrue = $minTerasSkim;
                        } else {
                            $terasSkimTrue = $check->mataTerasSkim;
                        }

                        /*             * ************************************************************************** */
                        //amountOfPoint that are actually counted
                        $jumlahMataAmbilKira = $elektifTrue + $terasUniTrue + $terasSkimTrue;
                        $jumlahMataSemasa = $check->mataElektif + $check->mataTerasUni + $check->mataTerasSkim + $check->mataUmum;
                    } elseif ($model3->jawatan->job_category == 1) {

                        //                            $minMata = $modelcpdgroup->mataMin;

                        //academic - comment out on 9/12/2020
                        //                            $minMata = $mataMin;
                        //
                        //                            $minTerasAcademic = round(0.5 * $minMata);
                        //                            $minElektifAcademic = round(0.3 * $minMata);
                        //                            $minUmumAcademic = round(0.2 * $minMata);

                        $minTerasAcademic = $mataMinTeras;
                        $minElektifAcademic = $mataMinElektif;
                        $minUmumAcademic = $mataMinUmum;

                        //determine IDP percentage and progress-bar colour
                        if ($check->mataElektif >= $minElektifAcademic) {
                            //electiveIDPPoint that are counted
                            $elektifTrue = $minElektifAcademic;
                        } else {
                            //electiveIDPPoint that are counted
                            $elektifTrue = $check->mataElektif;
                        }

                        /*             * ************************************************************************ */
                        if ($check->mataTeras >= $minTerasAcademic) {
                            $terasTrue = $minTerasAcademic;
                        } else {
                            $terasTrue = $check->mataTeras;
                        }

                        /*             * ************************************************************************** */
                        if ($check->mataUmum >= $minUmumAcademic) {
                            $umumTrue = $minUmumAcademic;
                        } else {
                            $umumTrue = $check->mataUmum;
                        }

                        /*************************************************************************** */
                        //amountOfPoint that are actually counted
                        $jumlahMataAmbilKira = $elektifTrue + $terasTrue + $umumTrue;
                        $jumlahMataSemasa = $check->mataElektif + $check->mataTeras + $check->mataUmum;
                    }

                    $new->jum_mata_dikira = $jumlahMataAmbilKira;
                    $new->jum_mata_semasa = $jumlahMataSemasa;

                    //$new->baki = $modelcpdgroup->mataMin - $jumlahMataAmbilKira;

                    $new->baki = $mataMin - $jumlahMataAmbilKira;

                    if ($new->baki == 0) {
                        $new->status = 2;
                    } elseif ($new->baki > 0) {
                        $new->status = 1;
                    }

                    $new->save(false);
                }
            }
        }
        /** closed check **/


        /**** xpenilaian ****/
        $check3 = IdpMataV2::find()
            ->where(['tahun' => date('Y')])
            ->all();

        foreach ($check3 as $check3) {

            $modelBB = RptStatistikIdpV2::find()
                ->where(['icno' => $check3->staffID])
                ->andWhere(['tahun' => date('Y')])
                ->one();

            if (!$modelBB) {
                $new2 = new RptStatistikIdpV2();
                $new2->icno = $check3->staffID;
                $new2->tahun = date('Y');
                $new2->staf_status = $check3->status;
                $new2->statusIDP = $check3->statusIDP;
                $new2->statusIDP2 = $check3->statusIDP2;
                $new2->tarikh_kemaskini = date('Y-m-d H:i:s');
                $new2->save(false);
            } else {
                $modelBB->staf_status = $check3->status;
                $modelBB->statusIDP = $check3->statusIDP;
                $modelBB->statusIDP2 = $check3->statusIDP2;
                $modelBB->tarikh_kemaskini = date('Y-m-d H:i:s');
                $modelBB->save(false);
            }
        }

        $new = RptStatistikIdpV2::find()
            ->where(['tahun' => date('Y')])
            ->all();

        foreach ($new as $new) {

            $check = IdpMataV2::find()
                ->where(['staffID' => $new->icno, 'tahun' => date('Y')])
                ->one();

            $new->idp_mata_teras = $check->mataTeras;
            $new->idp_mata_elektif = $check->mataElektif;
            $new->idp_mata_umum = $check->mataUmum;
            $new->idp_mata_teras_skim = $check->mataTerasSkim;
            $new->idp_mata_teras_uni = $check->mataTerasUni;

            /** calculate min **/
            $model3 = Tblprcobiodata::findOne(['ICNO' => $check->staffID]);

            if ($model3) {

                $gredj = $model3->jawatan->gred;

                $modelcpdgroupgj = RefCpdGroupGredJawatan::find()->where(['gred' => $gredj, 'tahun' => date('Y')])->one();

                if ($modelcpdgroupgj) {

                    $cpdgroup = $modelcpdgroupgj->cpdgroup;
                    $modelcpdgroup = RefCpdGroup::find()->where(['cpdgroup' => $cpdgroup, 'tahun' => date('Y')])->one();

                    //                        $new->idp_mata_min = $modelcpdgroup->mataMin;
                    //                        $new->idp_kom_teras_uni = $modelcpdgroup->minTerasUni;
                    //                        $new->idp_kom_teras_skim = $modelcpdgroup->minTerasSkim;
                    //                        $new->idp_kom_elektif = $modelcpdgroup->minElektif;
                    //                        $new->idp_kom_teras = $modelcpdgroup->minTeras;
                    //                        $new->idp_kom_umum = $modelcpdgroup->minUmum;

                    if (($new->staf_status == '1' && $new->statusIDP2 == '1') ||
                        ($new->staf_status == '1' && $new->statusIDP2 == '5') ||
                        ($new->staf_status == '1' && $new->statusIDP2 == '6') ||
                        ($new->staf_status == '1' && $new->statusIDP2 == '7')
                    ) {
                        //                        if ($new->staf_status == '1' && $new->statusIDP2 != '2'){
                        //                            if ($new->staf_status == '1' && $new->statusIDP2 != '3'){
                        $mataMin = $modelcpdgroup->mataMin;
                        $mataMinTerasUni = $modelcpdgroup->minTerasUni;
                        $mataMinTerasSkim = $modelcpdgroup->minTerasSkim;
                        $mataMinElektif = $modelcpdgroup->minElektif;
                        $mataMinTeras = $modelcpdgroup->minTeras;
                        $mataMinUmum = $modelcpdgroup->minUmum;
                        //                            }

                        //} elseif ($new->staf_status == '1' && $new->statusIDP2 == '2'){
                    } elseif (($new->staf_status == '2' && $new->statusIDP2 == '7') ||
                        ($new->staf_status == '3' && $new->statusIDP2 == '7') ||
                        ($new->staf_status == '4' && $new->statusIDP2 == '7')
                    ) {

                        $mataMin = 0;
                        $mataMinTerasUni = 0;
                        $mataMinTerasSkim = 0;
                        $mataMinElektif = 0;
                        $mataMinTeras = 0;
                        $mataMinUmum = 0;
                    } elseif (($new->staf_status == '1' && $new->statusIDP2 == '2')) {

                        if ($modelcpdgroup->mataMin != 0) {
                            $mataMin = round($modelcpdgroup->mataMin / 2, 0);
                        } else {
                            $mataMin = $modelcpdgroup->mataMin;
                        }

                        if ($modelcpdgroup->minTerasUni != 0) {
                            $mataMinTerasUni = round($modelcpdgroup->minTerasUni / 2, 0);
                        } else {
                            $mataMinTerasUni = $modelcpdgroup->minTerasUni;
                        }

                        if ($modelcpdgroup->minTerasSkim != 0) {
                            $mataMinTerasSkim = round($modelcpdgroup->minTerasSkim / 2, 0);
                        } else {
                            $mataMinTerasSkim = $modelcpdgroup->minTerasSkim;
                        }

                        if ($modelcpdgroup->minElektif != 0) {
                            $mataMinElektif = round($modelcpdgroup->minElektif / 2, 0);
                        } else {
                            $mataMinElektif = $modelcpdgroup->minElektif;
                        }

                        if ($modelcpdgroup->minTeras != 0) {
                            $mataMinTeras = round($modelcpdgroup->minTeras / 2, 0);
                        } else {
                            $mataMinTeras = $modelcpdgroup->minTeras;
                        }

                        if ($modelcpdgroup->minUmum != 0) {
                            $mataMinUmum = round($modelcpdgroup->minUmum / 2, 0);
                        } else {
                            $mataMinUmum = $modelcpdgroup->minUmum;
                        }
                    } elseif (($new->staf_status == '1' && $new->statusIDP2 == '3')) {

                        if ($modelcpdgroup->mataMin != 0) {
                            $mataMin = round(round($modelcpdgroup->mataMin / 2, 0) / 2, 0);
                        } else {
                            $mataMin = $modelcpdgroup->mataMin;
                        }

                        if ($modelcpdgroup->minTerasUni != 0) {
                            $mataMinTerasUni = round(round($modelcpdgroup->minTerasUni / 2, 0) / 2, 0);
                        } else {
                            $mataMinTerasUni = $modelcpdgroup->minTerasUni;
                        }

                        if ($modelcpdgroup->minTerasSkim != 0) {
                            $mataMinTerasSkim = round(round($modelcpdgroup->minTerasSkim / 2, 0) / 2, 0);
                        } else {
                            $mataMinTerasSkim = $modelcpdgroup->minTerasSkim;
                        }

                        if ($modelcpdgroup->minElektif != 0) {
                            $mataMinElektif = round(round($modelcpdgroup->minElektif / 2, 0) / 2, 0);
                        } else {
                            $mataMinElektif = $modelcpdgroup->minElektif;
                        }

                        if ($modelcpdgroup->minTeras != 0) {
                            $mataMinTeras = round(round($modelcpdgroup->minTeras / 2, 0) / 2, 0);
                        } else {
                            $mataMinTeras = $modelcpdgroup->minTeras;
                        }

                        if ($modelcpdgroup->minUmum != 0) {
                            $mataMinUmum = round(round($modelcpdgroup->minUmum / 2, 0) / 2, 0);
                        } else {
                            $mataMinUmum = $modelcpdgroup->minUmum;
                        }
                    }

                    if ($new->biodata->jawatan->job_category == 1) {
                        if (($mataMinTeras + $mataMinElektif + $mataMinUmum) > $mataMin) {
                            $mataMinUmum = $mataMinUmum - abs($mataMin - ($mataMinTeras + $mataMinElektif + $mataMinUmum));
                        }

                        //new 04/12/2020
                        $new->status_teras_uni = 0;
                        $new->status_teras_skim = 0;
                    } elseif ($new->biodata->jawatan->job_category == 2) {
                        if (($mataMinTerasUni + $mataMinElektif + $mataMinTerasSkim) > $mataMin) {
                            $mataMinElektif = $mataMinElektif - abs($mataMin - ($mataMinTerasUni + $mataMinElektif + $mataMinTerasSkim));
                        }

                        //new 04/12/2020
                        $new->status_teras = 0;
                        $new->status_umum = 1;
                    }

                    $new->idp_mata_min = $mataMin;
                    $new->idp_kom_teras_uni = $mataMinTerasUni;
                    $new->idp_kom_teras_skim = $mataMinTerasSkim;
                    $new->idp_kom_elektif = $mataMinElektif;
                    $new->idp_kom_teras = $mataMinTeras;
                    $new->idp_kom_umum = $mataMinUmum;

                    if ($model3->jawatan->job_category == 2) {

                        //                            $minElektif = $modelcpdgroup->minElektif; //fixed data in db
                        //                            $minTerasUniversiti = $modelcpdgroup->minTerasUni;
                        //                            $minTerasSkim = $modelcpdgroup->minTerasSkim;

                        $minElektif = $mataMinElektif; //fixed data in db
                        $minTerasUniversiti = $mataMinTerasUni;
                        $minTerasSkim = $mataMinTerasSkim;

                        if ($check->mataElektif >= $minElektif) {
                            //electiveIDPPoint that are counted
                            $elektifTrue = $minElektif;

                            //new 04/12/2020
                            $new->status_elektif = 1;
                        } else {
                            //electiveIDPPoint that are counted
                            $elektifTrue = $check->mataElektif;

                            //new 04/12/2020
                            $new->status_elektif = 2;
                        }

                        /*             * ************************************************************************ */
                        if ($check->mataTerasUni >= $minTerasUniversiti) {
                            $terasUniTrue = $minTerasUniversiti;

                            //new 04/12/2020
                            $new->status_teras_uni = 1;
                        } else {
                            $terasUniTrue = $check->mataTerasUni;

                            //new 04/12/2020
                            $new->status_teras_uni = 2;
                        }

                        /*             * ************************************************************************** */
                        if ($check->mataTerasSkim >= $minTerasSkim) {
                            $terasSkimTrue = $minTerasSkim;

                            //new 04/12/2020
                            $new->status_teras_skim = 1;
                        } else {
                            $terasSkimTrue = $check->mataTerasSkim;

                            //new 04/12/2020
                            $new->status_teras_skim = 2;
                        }

                        /*             * ************************************************************************** */
                        //amountOfPoint that are actually counted
                        $jumlahMataAmbilKira = $elektifTrue + $terasUniTrue + $terasSkimTrue;
                        $jumlahMataSemasa = $check->mataElektif + $check->mataTerasUni + $check->mataTerasSkim + $check->mataUmum;
                    } elseif ($model3->jawatan->job_category == 1) {

                        //                            $minMata = $modelcpdgroup->mataMin;

                        //academic - comment out on 9/12/2020
                        //                            $minMata = $mataMin;
                        //
                        //                            $minTerasAcademic = round(0.5 * $minMata);
                        //                            $minElektifAcademic = round(0.3 * $minMata);
                        //                            $minUmumAcademic = round(0.2 * $minMata);

                        $minTerasAcademic = $mataMinTeras;
                        $minElektifAcademic = $mataMinElektif;
                        $minUmumAcademic = $mataMinUmum;

                        //determine IDP percentage and progress-bar colour
                        if ($check->mataElektif >= $minElektifAcademic) {
                            //electiveIDPPoint that are counted
                            $elektifTrue = $minElektifAcademic;

                            //new 04/12/2020
                            $new->status_elektif = 1;
                        } else {
                            //electiveIDPPoint that are counted
                            $elektifTrue = $check->mataElektif;

                            //new 04/12/2020
                            $new->status_elektif = 2;
                        }

                        /*             * ************************************************************************ */
                        if ($check->mataTeras >= $minTerasAcademic) {
                            $terasTrue = $minTerasAcademic;

                            //new 04/12/2020
                            $new->status_teras = 1;
                        } else {
                            $terasTrue = $check->mataTeras;

                            //new 04/12/2020
                            $new->status_teras = 2;
                        }

                        /*             * ************************************************************************** */
                        if ($check->mataUmum >= $minUmumAcademic) {
                            $umumTrue = $minUmumAcademic;

                            //new 04/12/2020
                            $new->status_umum = 1;
                        } else {
                            $umumTrue = $check->mataUmum;

                            //new 04/12/2020
                            $new->status_umum = 2;
                        }

                        /*************************************************************************** */
                        //amountOfPoint that are actually counted
                        $jumlahMataAmbilKira = $elektifTrue + $terasTrue + $umumTrue;
                        $jumlahMataSemasa = $check->mataElektif + $check->mataTeras + $check->mataUmum;
                    }

                    $new->jum_mata_dikira = $jumlahMataAmbilKira;
                    $new->jum_mata_semasa = $jumlahMataSemasa;

                    //$new->baki = $modelcpdgroup->mataMin - $jumlahMataAmbilKira;

                    $new->baki = $mataMin - $jumlahMataAmbilKira;

                    if ($new->baki == 0) {
                        $new->status = 2;
                    } elseif ($new->baki > 0) {
                        $new->status = 1;
                    }

                    $new->save(false);
                }
            }
        }
        /** closed check **/

        echo "1";

        return ExitCode::OK;
    }

    public function actionAutoNoti()
    {

        $status = 0;

        $today = date('Y-m-d');

        $siriLatihan = SiriLatihan::find()->where(['statusSiriLatihan' => 'ACTIVE'])->all();
        foreach ($siriLatihan as $siriLatihan) {
            if ($siriLatihan->tarikhMula == $today) {
                $siriLatihan->statusSiriLatihan = "SEDANG BERJALAN";
                $siriLatihan->save(false);
            }
        }

        $modelSiri = PermohonanLatihan::find()
            ->joinWith('sasaran6')
            ->where(['statusSiriLatihan' => 'ACTIVE'])
            ->andWhere(['<>', 'tarikhMula', $today])
            ->all();

        foreach ($modelSiri as $modelSiri) {

            $dateSiri = date_create($modelSiri->sasaran6->tarikhMula);
            $dateBefore = date_sub($dateSiri, date_interval_create_from_date_string("7 days"));
            $dateBefore2 = date_format($dateBefore, "Y-m-d");

            if ($dateBefore2 == $today) {

                //$path = \yii\helpers\Url::toRoute('test/test');

                //--------Model Notification-----------//
                $ntf = new Notification(); //noti untuk kp
                $ntf->icno = $modelSiri->staffID;
                $ntf->title = 'MyIDP : Peringatan';
                if ($modelSiri->caraPermohonan == 'sendiriMohon') {

                    $ntf->content = "Kursus yang anda mohon " . strtoupper($modelSiri->sasaran3->tajukLatihan) . " Siri " . $modelSiri->sasaran6->siri . " akan dijalankan dalam tempoh seminggu. <a href='/staff/web/idp/view-senarai-permohonan' class='btn btn-primary'> PAPAR <i class='fa fa-arrow-right'></i></a>'";
                } elseif ($modelSiri->caraPermohonan == 'JEMPUTAN') {
                    $ntf->content = "Kursus yang anda dijemput " . strtoupper($modelSiri->sasaran3->tajukLatihan) . " akan dijalankan dalam tempoh seminggu. <a href='/staff/web/idp/view-senarai-permohonan' class='btn btn-primary'> PAPAR <i class='fa fa-arrow-right'></i></a>'";
                }
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save(false);
                //--------Model Notification-----------//

                if ($ntf->save(false)) {
                    echo "1";
                } else {
                    echo "2";
                }
            }

            $dateSiri2 = date_create($modelSiri->sasaran6->tarikhMula);
            $dateBeforeNew = date_sub($dateSiri2, date_interval_create_from_date_string("3 days"));
            $dateBefore2New = date_format($dateBeforeNew, "Y-m-d");

            if ($dateBefore2New == $today) {

                //$path = \yii\helpers\Url::toRoute('test/test');

                //--------Model Notification-----------//
                $ntf = new Notification(); //noti untuk kp
                $ntf->icno = $modelSiri->staffID;
                $ntf->title = 'MyIDP : Peringatan';
                if ($modelSiri->caraPermohonan == 'sendiriMohon') {

                    $ntf->content = "Kursus yang anda mohon " . strtoupper($modelSiri->sasaran3->tajukLatihan) . " Siri " . $modelSiri->sasaran6->siri . " akan dijalankan dalam tempoh tiga hari. <a href='/staff/web/idp/view-senarai-permohonan' class='btn btn-primary'> PAPAR <i class='fa fa-arrow-right'></i></a>'";
                } elseif ($modelSiri->caraPermohonan == 'JEMPUTAN') {
                    $ntf->content = "Kursus yang anda dijemput " . strtoupper($modelSiri->sasaran3->tajukLatihan) . " akan dijalankan dalam tempoh tiga hari. <a href='/staff/web/idp/view-senarai-permohonan' class='btn btn-primary'> PAPAR <i class='fa fa-arrow-right'></i></a>'";
                }
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save(false);
                //--------Model Notification-----------//

                if ($ntf->save(false)) {
                    echo "3";
                } else {
                    echo "4";
                }
            }
        }

        $modelSiriLulus = PermohonanLatihan::find()
            ->joinWith('sasaran6')
            ->where(['statusSiriLatihan' => 'SEDANG BERJALAN', 'statusPermohonan' => 'DILULUSKAN', 'tarikhMula' => $today])
            ->all();

        //if ($modelSiriLulus > 0){ echo $today;} else {echo "TIADA";}

        foreach ($modelSiriLulus as $modelSiriLulus) {

            //--------Model Notification-----------//
            $ntf = new Notification(); //noti untuk kp
            $ntf->icno = $modelSiriLulus->staffID;
            $ntf->title = 'MyIDP : Peringatan';

            if ($modelSiriLulus->caraPermohonan == 'sendiriMohon') {

                $ntf->content = "Kursus yang anda mohon " . strtoupper($modelSiriLulus->sasaran3->tajukLatihan) . " Siri " . $modelSiriLulus->sasaran6->siri . " akan dijalankan pada hari ini. <a href='/staff/web/idp/view-senarai-permohonan' class='btn btn-primary'> PAPAR <i class='fa fa-arrow-right'></i></a>'";
            } elseif ($modelSiriLulus->caraPermohonan == 'JEMPUTAN') {
                $ntf->content = "Kursus yang anda dijemput " . strtoupper($modelSiriLulus->sasaran3->tajukLatihan) . " akan dijalankan pada hari ini. <a href='/staff/web/idp/view-senarai-permohonan' class='btn btn-primary'> PAPAR <i class='fa fa-arrow-right'></i></a>'";
            }
            $ntf->ntf_dt = date('Y-m-d H:i:s');
            $ntf->save(false);
            //--------Model Notification-----------//

            if ($ntf->save(false)) {
                echo "5";
            } else {
                echo "6";
            }
        }

        return ExitCode::OK;
    }

    public function actionAutoRedirectSector()
    {
        //get current year
        $currentYear = date('Y');

        $check = PermohonanMataIdpIndividu::find()
            ->where("SUBSTRING(tarikhPohon,1,4) = $currentYear and statusPermohonan = '3'")
            ->orderBy(['tarikhPohon' => SORT_ASC])
            ->limit(25)
            ->all();

        foreach ($check as $check) {

            $check->statusPermohonan = "33";
            $check->save(false);
        }

        echo "1";

        return ExitCode::OK;
    }

    public function actionAutoAddKursus()
    {
        $arrayKursusJfpiu = KursusLatihan::find()
            ->where(['<>', 'kursusID', NULL])
            ->all();

        $check = KursusLatihanJfpiu::find()
            ->where(['not in', 'kursusLatihanID', $arrayKursusJfpiu])
            ->all();

        foreach ($check as $model) {

            $kursus = new KursusLatihan();
            $kursus->unitBertanggungjawab = 'JFPIU';
            $kursus->jenisLatihanID = 'jfpiu';
            $kursus->statusKursusLatihan = 'AKTIF';
            $kursus->tajukLatihan = $model->tajukLatihan;
            $kursus->kursusID = $model->kursusLatihanID;
            $kursus->penggubalModul = $model->penggubalModul;

            if ($kursus->save(false)) {

                $model2 = SiriLatihanJfpiu::find()
                    ->where(['kursusLatihanID' => $model->kursusLatihanID])
                    ->one();

                $siriLatihan = new SiriLatihan();
                $siriLatihan->kursusLatihanID = $kursus->kursusLatihanID;
                $siriLatihan->siri = $model2->siri;
                $siriLatihan->lokasi = $model2->lokasi;
                $siriLatihan->tarikhMula = $model2->tarikhMula;
                $siriLatihan->tarikhAkhir = $model2->tarikhAkhir;
                $siriLatihan->statusSiriLatihan = 'SEDANG BERJALAN';

                if ($siriLatihan->save(false)) {

                    $model3 = SlotLatihanJfpiu::find()
                        ->where(['siriLatihanID' => $model2->siriLatihanID])
                        ->one();

                    $slotLatihan = new SlotLatihan();
                    $slotLatihan->siriLatihanID = $siriLatihan->siriLatihanID;
                    $slotLatihan->slot = $model3->slot;
                    $slotLatihan->mataSlot = $model2->jumlahMataIDP;

                    if ($slotLatihan->save(false)) {

                        $model4 = KehadiranJfpiu::find()
                            ->where(['slotID' => $model3->slotID])
                            ->all();

                        foreach ($model4 as $modelKehadiran) {

                            $modelK = new Kehadiran();
                            $modelK->slotID = $slotLatihan->slotID;
                            $modelK->staffID = $modelKehadiran->staffID;
                            $modelK->tarikhMasa = $modelKehadiran->tarikhMasa;
                            $modelK->kategoriKursusID = $modelKehadiran->kategoriKursusID;
                            $modelK->save(false);
                            echo "2";
                        }
                    }

                    echo "2";
                }
            }
        }

        echo "1";

        return ExitCode::OK;
    }

    //    public function actionAutoUpdateSandangan(){
    //        
    //        $modelRpt = RptStatistikIdpV2::find()
    //                ->where(['tahun' => date('Y')])
    //                ->all();
    //        
    //        foreach ($modelRpt as $model){
    //            
    //            $modelSandangan = Tblrscosandangan::find()
    //                    ->where(['ICNO' => $model->icno])
    //                    ->orderBy(['id' => SORT_DESC])
    //                    ->one();
    //            
    //            $model->sandangan_id = $modelSandangan->id;
    //            $model->save(false);
    //        
    //        }
    //        
    //        $modelRpt2 = RptStatistikIdpV2::find()
    //                ->where(['tahun' => '2020'])
    //                ->all();
    //        
    //        foreach ($modelRpt2 as $model){
    //            
    //            $modelSandangan = Tblrscosandangan::find()
    //                    ->where(['ICNO' => $model->icno])
    //                    ->andWhere(['<>', 'YEAR(start_date)', '2021'])
    //                    ->orderBy(['id' => SORT_DESC])
    //                    ->one();
    //            
    //            $model->sandangan_id = $modelSandangan->id;
    //            $model->save(false);
    //        
    //        }
    //        
    //        echo "1";  
    //    
    //        return ExitCode::OK;
    //    }

    public function actionUpdateStatisticsPercent()
    {

        // FIXME: fix this

        // $modelKumpKhidmat = Kumpulankhidmat::find()->where(['<>', 'name', 'Khas'])->select('id')->distinct()->all();
        // $modelStatistik = IdpStatistik::find()->select('kumpkhidmat_id')->distinct()->all();

        // //$result = array_diff($modelKumpKhidmat, $modelStatistik); 

        // var_dump($modelKumpKhidmat);
        // die;

        // if (count($result) > 0){
        //     foreach ($result as $r){
        //         $model = new IdpStatistik();
        //         $model->kumpkhidmat_id = $r->id;

        //         if ($model->save(false)){
        //             echo "1";
        //         } else {
        //             echo "2";
        //         }
        //     }
        // }

        $year = date('Y');

        /* STATISTIK KESELURUHAN */
        $modelStatistik = IdpStatistik::find()->where(['tahun' => $year])->all();

        foreach ($modelStatistik as $m) {
            $m->jumlah_staf = Kumpulankhidmat::countStaff($m->kumpkhidmat_id, 0, $year);
            $m->jumlah_capai = RptStatistikIdp::countStatistics($m->kumpkhidmat_id, 0, 0, $year);
            $m->jumlah_belum_capai = RptStatistikIdp::countStatistics($m->kumpkhidmat_id, 0, 1, $year);
            $m->jumlah_belum_ada_mata = RptStatistikIdp::countStatistics($m->kumpkhidmat_id, 0, 2, $year);

            if ($m->save(false)) {
                echo "1";

                if ($m->jumlah_staf > 0) {
                    $m->per_jumlah_capai = round($m->jumlah_capai / $m->jumlah_staf * 100);
                    $m->per_jumlah_belum_capai = round($m->jumlah_belum_capai / $m->jumlah_staf * 100);
                    $m->per_jumlah_belum_ada_mata = round($m->jumlah_belum_ada_mata / $m->jumlah_staf * 100);
                } else {
                    $m->per_jumlah_capai = 0;
                    $m->per_jumlah_belum_capai = 0;
                    $m->per_jumlah_belum_ada_mata = 0;
                }

                if ($m->save(false)) {
                    date_default_timezone_set("Asia/Kuala_Lumpur");
                    //echo date('d-m-Y H:i:s'); //Returns IST
                    $m->tarikh_kemaskini = date('Y-m-d H:i:s');
                    $m->save(false);
                    echo "4";
                } else {
                    echo "5";
                }
            } else {
                echo "2";
            }
        }

        /* STATISTIK AKADEMIK */
        $modelStatistikAkademik = IdpStatistikAkademik::find()->where(['tahun' => $year])->all();

        foreach ($modelStatistikAkademik as $m) {
            $m->jumlah_staf = Kumpulankhidmat::countStaff($m->vckl_kod_kumpulan, 1, $year);
            $m->jumlah_capai = RptStatistikIdp::countStatistics($m->vckl_kod_kumpulan, 1, 0, $year);
            $m->jumlah_belum_capai = RptStatistikIdp::countStatistics($m->vckl_kod_kumpulan, 1, 1, $year);
            $m->jumlah_belum_ada_mata = RptStatistikIdp::countStatistics($m->vckl_kod_kumpulan, 1, 2, $year);

            if ($m->save(false)) {
                echo "1";

                if ($m->jumlah_staf > 0) {
                    $m->per_jumlah_capai = round($m->jumlah_capai / $m->jumlah_staf * 100);
                    $m->per_jumlah_belum_capai = round($m->jumlah_belum_capai / $m->jumlah_staf * 100);
                    $m->per_jumlah_belum_ada_mata = round($m->jumlah_belum_ada_mata / $m->jumlah_staf * 100);
                } else {
                    $m->per_jumlah_capai = 0;
                    $m->per_jumlah_belum_capai = 0;
                    $m->per_jumlah_belum_ada_mata = 0;
                }

                if ($m->save(false)) {
                    date_default_timezone_set("Asia/Kuala_Lumpur");
                    //echo date('d-m-Y H:i:s'); //Returns IST
                    $m->tarikh_kemaskini = date('Y-m-d H:i:s');
                    $m->save(false);
                    echo "4";
                } else {
                    echo "5";
                }
            } else {
                echo "2";
            }
        }

        /* STATISTIK PENTADBIRAN */
        $modelStatistikPentadbiran = IdpStatistikPentadbiran::find()->where(['tahun' => $year])->all();

        foreach ($modelStatistikPentadbiran as $m) {
            $m->jumlah_staf = Kumpulankhidmat::countStaff($m->vckl_kod_kumpulan, 2, $year);
            $m->jumlah_capai = RptStatistikIdp::countStatistics($m->vckl_kod_kumpulan, 2, 0, $year);
            $m->jumlah_belum_capai = RptStatistikIdp::countStatistics($m->vckl_kod_kumpulan, 2, 1, $year);
            $m->jumlah_belum_ada_mata = RptStatistikIdp::countStatistics($m->vckl_kod_kumpulan, 2, 2, $year);

            if ($m->save(false)) {
                echo "1";

                if ($m->jumlah_staf > 0) {
                    $m->per_jumlah_capai = round($m->jumlah_capai / $m->jumlah_staf * 100);
                    $m->per_jumlah_belum_capai = round($m->jumlah_belum_capai / $m->jumlah_staf * 100);
                    $m->per_jumlah_belum_ada_mata = round($m->jumlah_belum_ada_mata / $m->jumlah_staf * 100);
                } else {
                    $m->per_jumlah_capai = 0;
                    $m->per_jumlah_belum_capai = 0;
                    $m->per_jumlah_belum_ada_mata = 0;
                }

                if ($m->save(false)) {
                    date_default_timezone_set("Asia/Kuala_Lumpur");
                    //echo date('d-m-Y H:i:s'); //Returns IST
                    $m->tarikh_kemaskini = date('Y-m-d H:i:s');
                    $m->save(false);
                    echo "4";
                } else {
                    echo "5";
                }
            } else {
                echo "2";
            }
        }

        /** STATISTIK JABATAN */
        $year2 = date('Y');
        $modelDept = Department::find()->where(['isActive' => '1'])->all();

        foreach ($modelDept as $d) {

            $j = IdpStatistikJabatan::find()->where(['dept_id' => $d->id, 'tahun' => $year2])->one();

            if (!$j) {
                $modelJabatan = new IdpStatistikJabatan();
                $modelJabatan->dept_id = $d->id;
                $modelJabatan->tahun = $year2;
                if ($modelJabatan->save(false)) {
                    echo "6";
                } else {
                    echo "7";
                }
            }
        }

        $modelJabatan = IdpStatistikJabatan::find()->where(['tahun' => $year2])->all();

        foreach ($modelJabatan as $m) {
            $m->jumlah_staf = Department::countStaffDeptLayak($m->dept_id, 0, $year2);
            $m->jumlah_capai = RptStatistikIdp::countStatisticsDept($m->dept_id, 0, 0, $year2);
            $m->jumlah_belum_capai = RptStatistikIdp::countStatisticsDept($m->dept_id, 0, 1, $year2);
            $m->jumlah_belum_ada_mata = RptStatistikIdp::countStatisticsDept($m->dept_id, 0, 2, $year2);

            if ($m->save(false)) {
                echo "8";

                if ($m->jumlah_staf > 0) {
                    $m->per_jumlah_capai = round($m->jumlah_capai / $m->jumlah_staf * 100);
                    $m->per_jumlah_belum_capai = round($m->jumlah_belum_capai / $m->jumlah_staf * 100);
                    $m->per_jumlah_belum_ada_mata = round($m->jumlah_belum_ada_mata / $m->jumlah_staf * 100);
                } else {
                    $m->per_jumlah_capai = 0;
                    $m->per_jumlah_belum_capai = 0;
                    $m->per_jumlah_belum_ada_mata = 0;
                }

                if ($m->save(false)) {
                    date_default_timezone_set("Asia/Kuala_Lumpur");
                    $m->tarikh_kemaskini = date('Y-m-d H:i:s');
                    $m->save(false);
                    echo "9";
                } else {
                    echo "10";
                }
            } else {
                echo "2";
            }
        }

        /** STATISTIK PENCAPAIAN PELAKSANAAN KURSUS DALAMAN BY BULAN (2019 and below) */
        $year2 = '2019';
        $modelBulan = TblMonths::find()->all();

        foreach ($modelBulan as $d) {

            $j = StatistikKursusDalamanByBulan::find()->where(['month_id' => $d->id, 'tahun' => $year2])->one();

            if (!$j) {
                $modelj = new StatistikKursusDalamanByBulan();
                $modelj->month_id = $d->id;
                $modelj->tahun = $year2;
                if ($modelj->save(false)) {
                    echo "6";
                } else {
                    echo "7";
                }
            }
        }

        $modelj = StatistikKursusDalamanByBulan::find()->where(['tahun' => $year2])->all();

        foreach ($modelj as $m) {
            $m->jumlah_kursus = VCpdSenaraiLatihan::countKursusByMonthlyStatus($m->month_id, 0, $year2);
            $m->jumlah_terlaksana = VCpdSenaraiLatihan::countKursusByMonthlyStatus($m->month_id, 1, $year2);
            $m->jumlah_belum_laksana = VCpdSenaraiLatihan::countKursusByMonthlyStatus($m->month_id, 3, $year2);
            $m->jumlah_tangguh = VCpdSenaraiLatihan::countKursusByMonthlyStatus($m->month_id, 5, $year2);

            if ($m->save(false)) {
                echo "8";

                if ($m->jumlah_kursus > 0) {
                    $m->per_jumlah_terlaksana = round($m->jumlah_terlaksana / $m->jumlah_kursus * 100);
                    $m->per_jumlah_belum_laksana = round($m->jumlah_belum_laksana / $m->jumlah_kursus * 100);
                    $m->per_jumlah_tangguh = round($m->jumlah_tangguh / $m->jumlah_kursus * 100);
                } else {
                    $m->per_jumlah_terlaksana = 0;
                    $m->per_jumlah_belum_laksana = 0;
                    $m->per_jumlah_tangguh = 0;
                }

                if ($m->save(false)) {
                    date_default_timezone_set("Asia/Kuala_Lumpur");
                    $m->tarikh_kemaskini = date('Y-m-d H:i:s');
                    $m->save(false);
                    echo "9";
                } else {
                    echo "10";
                }
            } else {
                echo "2";
            }
        }

        /** STATISTIK PENCAPAIAN PELAKSANAAN KURSUS DALAMAN BY BULAN */
        $year2 = date('Y');
        $modelBulan = TblMonths::find()->all();

        foreach ($modelBulan as $d) {

            $j = StatistikKursusDalamanByBulan::find()->where(['month_id' => $d->id, 'tahun' => $year2])->one();

            if (!$j) {
                $modelj = new StatistikKursusDalamanByBulan();
                $modelj->month_id = $d->id;
                $modelj->tahun = $year2;
                if ($modelj->save(false)) {
                    echo "6";
                } else {
                    echo "7";
                }
            }
        }

        $modelj = StatistikKursusDalamanByBulan::find()->where(['tahun' => $year2])->all();

        foreach ($modelj as $m) {
            $m->jumlah_kursus = SiriLatihan::countKursusByMonthlyStatus($m->month_id, 0, $year2);
            $m->jumlah_terlaksana = SiriLatihan::countKursusByMonthlyStatus($m->month_id, 1, $year2);
            $m->jumlah_belum_laksana = SiriLatihan::countKursusByMonthlyStatus($m->month_id, 3, $year2);
            $m->jumlah_tangguh = SiriLatihan::countKursusByMonthlyStatus($m->month_id, 5, $year2);

            if ($m->save(false)) {
                echo "8";

                if ($m->jumlah_kursus > 0) {
                    $m->per_jumlah_terlaksana = round($m->jumlah_terlaksana / $m->jumlah_kursus * 100);
                    $m->per_jumlah_belum_laksana = round($m->jumlah_belum_laksana / $m->jumlah_kursus * 100);
                    $m->per_jumlah_tangguh = round($m->jumlah_tangguh / $m->jumlah_kursus * 100);
                } else {
                    $m->per_jumlah_terlaksana = 0;
                    $m->per_jumlah_belum_laksana = 0;
                    $m->per_jumlah_tangguh = 0;
                }

                if ($m->save(false)) {
                    date_default_timezone_set("Asia/Kuala_Lumpur");
                    $m->tarikh_kemaskini = date('Y-m-d H:i:s');
                    $m->save(false);
                    echo "9";
                } else {
                    echo "10";
                }
            } else {
                echo "2";
            }
        }

        /** STATISTIK PENCAPAIAN PELAKSANAAN KURSUS DALAMAN BY BULAN (KEHADIRAN) (2019 and below)*/
        $year2 = '2019';
        $modelBulan = TblMonths::find()->all();

        foreach ($modelBulan as $d) {

            $j = StatistikKursusDalamanByKehadiran::find()->where(['month_id' => $d->id, 'tahun' => $year2])->one();

            if (!$j) {
                $modelj = new StatistikKursusDalamanByKehadiran();
                $modelj->month_id = $d->id;
                $modelj->tahun = $year2;
                if ($modelj->save(false)) {
                    echo "6";
                } else {
                    echo "7";
                }
            }
        }

        $modelj = StatistikKursusDalamanByKehadiran::find()->where(['tahun' => $year2])->all();

        foreach ($modelj as $m) {
            $m->jumlah_terlaksana = VCpdSenaraiLatihan::countKursusByMonthlyStatus($m->month_id, 1, $year2);
            $m->jumlah_memohon = MohonKursusLama::calculatePemohonByMonth($m->month_id, $year2);
            $m->jumlah_hadir = VCpdlatihan::calculatePesertaByMonth($m->month_id, $year2);
            $m->jumlah_walk_in = VCpdlatihan::calculatePesertaWalkIn($m->month_id, $year2);

            if ($m->jumlah_terlaksana == 0) {
                $m->jumlah_tidak_hadir = 0;
            } else {
                $m->jumlah_tidak_hadir = $m->jumlah_memohon - ($m->jumlah_hadir - $m->jumlah_walk_in);
            }

            if ($m->save(false)) {
                echo "8";

                if (($m->jumlah_terlaksana > 0) && ($m->jumlah_memohon > 0)) {
                    $m->per_jumlah_hadir = round(($m->jumlah_hadir - $m->jumlah_walk_in) / $m->jumlah_memohon * 100);
                    $m->per_jumlah_tidak_hadir = round($m->jumlah_tidak_hadir / $m->jumlah_memohon * 100);
                } else {
                    $m->per_jumlah_hadir = 0;
                    $m->per_jumlah_tidak_hadir = 0;
                }

                if ($m->save(false)) {
                    date_default_timezone_set("Asia/Kuala_Lumpur");
                    $m->tarikh_kemaskini = date('Y-m-d H:i:s');
                    $m->save(false);
                    echo "9";
                } else {
                    echo "10";
                }
            } else {
                echo "2";
            }
        }

        /** STATISTIK PENCAPAIAN PELAKSANAAN KURSUS DALAMAN BY BULAN (KEHADIRAN) */
        $year2 = date('Y');
        $modelBulan = TblMonths::find()->all();

        foreach ($modelBulan as $d) {

            $j = StatistikKursusDalamanByKehadiran::find()->where(['month_id' => $d->id, 'tahun' => $year2])->one();

            if (!$j) {
                $modelj = new StatistikKursusDalamanByKehadiran();
                $modelj->month_id = $d->id;
                $modelj->tahun = $year2;
                if ($modelj->save(false)) {
                    echo "6";
                } else {
                    echo "7";
                }
            }
        }

        $modelj = StatistikKursusDalamanByKehadiran::find()->where(['tahun' => $year2])->all();

        foreach ($modelj as $m) {
            $m->jumlah_terlaksana = SiriLatihan::countKursusByMonthlyStatus($m->month_id, 1, $year2);
            $m->jumlah_memohon = PermohonanLatihan::calculatePemohonByMonth($m->month_id, $year2);
            $m->jumlah_hadir = KehadiranSiri::calculatePesertaByMonth($m->month_id, $year2);
            $m->jumlah_walk_in = KehadiranSiri::calculatePesertaWalkIn($m->month_id, $year2);

            if ($m->jumlah_terlaksana == 0) {
                $m->jumlah_tidak_hadir = 0;
            } else {
                $m->jumlah_tidak_hadir = PermohonanLatihan::calculatePemohonByMonth($m->month_id, $year2) - ($m->jumlah_hadir - $m->jumlah_walk_in);
            }

            if ($m->save(false)) {
                echo "8";

                if (($m->jumlah_terlaksana > 0) && ($m->jumlah_memohon > 0)) {
                    $m->per_jumlah_hadir = round(($m->jumlah_hadir - $m->jumlah_walk_in) / $m->jumlah_memohon * 100);
                    $m->per_jumlah_tidak_hadir = round($m->jumlah_tidak_hadir / $m->jumlah_memohon * 100);
                } else {
                    $m->per_jumlah_hadir = 0;
                    $m->per_jumlah_tidak_hadir = 0;
                }

                if ($m->save(false)) {
                    date_default_timezone_set("Asia/Kuala_Lumpur");
                    $m->tarikh_kemaskini = date('Y-m-d H:i:s');
                    $m->save(false);
                    echo "9";
                } else {
                    echo "10";
                }
            } else {
                echo "2";
            }
        }

        /** STATISTIK KURSUS LUAR */
        $year2 = date('Y');
        $modelBulan = TblMonths::find()->all();

        foreach ($modelBulan as $d) {

            $j = StatistikKursusLuar::find()->where(['month_id' => $d->id, 'tahun' => $year2])->one();

            if (!$j) {
                $modelj = new StatistikKursusLuar();
                $modelj->month_id = $d->id;
                $modelj->tahun = $year2;
                if ($modelj->save(false)) {
                    echo "6";
                } else {
                    echo "7";
                }
            }
        }

        $modelj = StatistikKursusLuar::find()->where(['tahun' => $year2])->all();

        foreach ($modelj as $m) {
            $m->jum_pohon_pengurusan = PermohonanKursusLuar::countKursusByStaffCategory($m->month_id, 0, $year2);
            $m->jum_pohon_pelaksana = PermohonanKursusLuar::countKursusByStaffCategory($m->month_id, 1, $year2);
            $m->jum_lulus_pengurusan = PermohonanKursusLuar::countKursusByStaffCategory($m->month_id, 2, $year2);
            $m->jum_lulus_pelaksana = PermohonanKursusLuar::countKursusByStaffCategory($m->month_id, 3, $year2);

            if ($m->save(false)) {
                echo "8";

                if ($m->save(false)) {
                    date_default_timezone_set("Asia/Kuala_Lumpur");
                    $m->tarikh_kemaskini = date('Y-m-d H:i:s');
                    $m->save(false);
                    echo "9";
                } else {
                    echo "10";
                }
            } else {
                echo "2";
            }
        }

        /** STATISTIK PERMOHONAN MATA IDP */
        $year2 = date('Y');
        $modelBulan = TblMonths::find()->all();

        foreach ($modelBulan as $d) {

            $j = StatistikPermohonanMata::find()->where(['month_id' => $d->id, 'tahun' => $year2])->one();

            if (!$j) {
                $modelj = new StatistikPermohonanMata();
                $modelj->month_id = $d->id;
                $modelj->tahun = $year2;
                if ($modelj->save(false)) {
                    echo "6";
                } else {
                    echo "7";
                }
            }
        }

        $modelj = StatistikPermohonanMata::find()->where(['tahun' => $year2])->all();

        foreach ($modelj as $m) { 
            /** akademik tiada kakitangan kategori pelaksana */
            $m->jum_pohon_pengurusan_aka = Peserta::countKursusByStaffCategory($m->month_id, 0, $year2, 1);
            $m->jum_lulus_pengurusan_aka = Peserta::countKursusByStaffCategory($m->month_id, 2, $year2, 1);

            /** pentadbiran jak ada pelaksana */
            $m->jum_pohon_pengurusan_pen = Peserta::countKursusByStaffCategory($m->month_id, 0, $year2, 2);
            $m->jum_pohon_pelaksana_pen = Peserta::countKursusByStaffCategory($m->month_id, 1, $year2, 2);
            $m->jum_lulus_pengurusan_pen = Peserta::countKursusByStaffCategory($m->month_id, 2, $year2, 2);
            $m->jum_lulus_pelaksana_pen = Peserta::countKursusByStaffCategory($m->month_id, 3, $year2, 2);

            if ($m->save(false)) {
                echo "8";

                if ($m->save(false)) {
                    date_default_timezone_set("Asia/Kuala_Lumpur");
                    $m->tarikh_kemaskini = date('Y-m-d H:i:s');
                    $m->save(false);
                    echo "9";
                } else {
                    echo "10";
                }
            } else {
                echo "2";
            }
        }

        /* STATISTIK PENTADBIRAN BY GRED SKIM */
        $year2 = date('Y');

        $array = RefCpdGroupGredJawatan::find()
            ->where(['tahun' => $year2])
            ->groupBy('gred_skim')
            ->orderBy('gred_skim')
            ->all();

        // $model = GredJawatan::find()
        //     ->where(['in', 'gred_skim', $array])
        //     ->andWhere(['job_category' => '2'])
        //     ->groupBy('gred_skim')
        //     ->orderBy('gred_skim');

        foreach ($array as $d) {

            $j = StatistikSkimPentadbiran::find()->where(['gred_skim' => $d->gred_skim, 'tahun' => $year2])->one();

            if (!$j) {
                $modelj = new StatistikSkimPentadbiran();
                $modelj->gred_skim = $d->gred_skim;
                $modelj->tahun = $year2;
                if ($modelj->save(false)) {
                    echo "6";
                } else {
                    echo "7";
                }
            }
        }

        $modelSkim = StatistikSkimPentadbiran::find()->where(['tahun' => $year2])->all();

        foreach ($modelSkim as $m) {
            $m->jumlah_staf = RefCpdGroupGredJawatan::countStaff($m->gred_skim, $year2);
            $m->jumlah_capai = RptStatistikIdp::countStatisticsByScheme($m->gred_skim, 2, $year2);
            $m->jumlah_belum_capai = RptStatistikIdp::countStatisticsByScheme($m->gred_skim, 1, $year2);
            $m->jumlah_belum_ada_mata = RptStatistikIdp::countStatisticsByScheme($m->gred_skim, 0, $year2);

            if ($m->save(false)) {
                echo "1";

                if ($m->jumlah_staf > 0) {
                    $m->per_jumlah_capai = round($m->jumlah_capai / $m->jumlah_staf * 100);
                    $m->per_jumlah_belum_capai = round($m->jumlah_belum_capai / $m->jumlah_staf * 100);
                    $m->per_jumlah_belum_ada_mata = round($m->jumlah_belum_ada_mata / $m->jumlah_staf * 100);
                } else {
                    $m->per_jumlah_capai = 0;
                    $m->per_jumlah_belum_capai = 0;
                    $m->per_jumlah_belum_ada_mata = 0;
                }

                if ($m->save(false)) {
                    date_default_timezone_set("Asia/Kuala_Lumpur");
                    //echo date('d-m-Y H:i:s'); //Returns IST
                    $m->tarikh_kemaskini = date('Y-m-d H:i:s');
                    $m->save(false);
                    echo "4";
                } else {
                    echo "5";
                }
            } else {
                echo "2";
            }
        }

        echo "3";
        return ExitCode::OK;
    }

    public function actionUpdateKehadiranSiri()
    {

        // $model = Kehadiran::find()
        //         ->joinWith('sasaran9')
        //         ->where(['YEAR(tarikhMasa)' => date('Y')])
        //         ->groupBy(['idp_slotlatihan.siriLatihanID', 'staffID'])
        //         ->all();

        $model = Kehadiran::find()
            ->joinWith('sasaran9')
            ->groupBy(['idp_slotlatihan.siriLatihanID', 'staffID'])
            ->all();

        foreach ($model as $m) {

            if ($m->sasaran9) {

                $modelHadirSiri = KehadiranSiri::find()
                    ->where(['idp_kehadiran_siri.siriLatihanID' => $m->sasaran9->siriLatihanID])
                    ->andWhere(['idp_kehadiran_siri.staffID' => $m->staffID])
                    ->one();

                if (!$modelHadirSiri) {
                    $modelSiri = new KehadiranSiri();
                    $modelSiri->siriLatihanID = $m->sasaran9->siriLatihanID;
                    $modelSiri->staffID = $m->staffID;
                    $modelSiri->kompetensi = $m->kategoriKursusID;

                    if ($modelSiri->save(false)) {
                        date_default_timezone_set("Asia/Kuala_Lumpur");
                        //echo date('d-m-Y H:i:s'); //Returns IST
                        $modelSiri->tarikhMasa = date('Y-m-d H:i:s');
                        $modelSiri->save(false);
                        echo "1";
                    } else {
                        echo "2";
                    }
                }
            }
        }
    }
}
