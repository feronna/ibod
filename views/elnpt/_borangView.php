<?php
/* @var $this yii\web\View */

use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;
use kartik\dialog\Dialog;
use yii\helpers\ArrayHelper;
use dosamigos\chartjs\ChartJs;
use yii\web\JsExpression;

$label = ArrayHelper::getColumn($markah, 'aspek');

//$bgColor = [];
$bColor = [];
$hColor = [];
foreach ($label as $lab) {
    //array_push($bgColor, sprintf('#%06X', mt_rand(0, 0xFFFFFF)));
    array_push($bColor, '#fff');
    array_push($hColor, '#999');
}

$abc = 1;

if ($lpp->PYD == Yii::$app->user->identity->ICNO) {
    if ($lpp->PYD_sah == 1) {
        $flag = true;
    } else {
        $flag = false;
    }
} else {
    $flag = true;
}

?>

<script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/latest.js?config=TeX-MML-AM_CHTML' async></script>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Maklumat Guru</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?=
                        DetailView::widget([
                            'model' => $query,
                            'attributes' => [
                                [
                                    'label' => 'Tahun Penilaian',
                                    'value' => function ($model) {
                                        return $model->tahun;
                                    },
                                    'captionOptions' => ['style' => 'width:20%'],
                                ],
                                [
                                    'label' => 'Tempoh Pengisian',
                                    'value' => function ($model) {
                                        return Yii::$app->formatter->asDate($model->tahunLpp->lpp_trkh_hantar, 'dd/MM/yyyy') . ' hingga ' . Yii::$app->formatter->asDate($model->tahunLpp->pengisian_PYD_tamat, 'dd/MM/yyyy');
                                    },

                                ],
                                [
                                    'label' => 'Nama',
                                    'value' => function ($model) {
                                        return $model->guru->CONm;
                                    },
                                ],
                                [
                                    'label' => 'Gred / Jawatan',
                                    'value' => function ($model) {
                                        return $model->gredGuru->fname;
                                    }
                                ],
                                [
                                    'label' => 'No. UMSPER',
                                    'value' => function ($model) {
                                        return $model->guru->COOldID;
                                    },
                                ],
                                [
                                    'label' => 'No. Kad Pengenalan / No. Passport',
                                    'value' => function ($model) {
                                        return $model->guru->ICNO;
                                    },
                                ],
                                [
                                    'label' => 'J/S/P/I/U',
                                    'value' => function ($model) {
                                        return $model->deptGuru->fullname;
                                    },
                                ],
                                [
                                    'label' => 'PPP',
                                    'value' => function ($model) {
                                        return is_null($model->ppp) ? '<b>Pegawai Penilai Pertama Belum Ditetapkan. Sila Berhubung dengan Penetap Penilai di J/S/P/I/U anda.</b>' : $model->ppp->CONm;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'PPK',
                                    'value' => function ($model) {
                                        return is_null($model->ppk) ? '<b>Pegawai Penilai Kedua Belum Ditetapkan. Sila Berhubung dengan Penetap Penilai di J/S/P/I/U anda.</b>' : $model->ppk->CONm;
                                        return $model->ppk->CONm;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'PEER',
                                    'value' => function ($model) {
                                        return is_null($model->peer) ? '<b>Peer Belum Ditetapkan. Sila Berhubung dengan Penetap Penilai di J/S/P/I/U anda.</b>' : '<b>Peer Sudah Ditetapkan.</b>';
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'CATATAN',
                                    'value' => function ($model) {
                                        return $model->catatan;
                                    },
                                ],
                            ],
                        ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<pagebreak />

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Bahagian 1 : Pengajaran & Pembelajaran (P&P)</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center" rowspan="2">BIL.</th>

                                <th class="text-center" rowspan="2">PPP SAH</th>

                                <th class="text-center" rowspan="2">KOD KURSUS</th>
                                <th class="text-center" rowspan="2">NAMA KURSUS</th>
                                <th class="text-center" rowspan="2">BIL. PELAJAR</th>
                                <th class="text-center" rowspan="2">SEKSYEN</th>
                                <th class="text-center" rowspan="2">SEMESTER</th>
                                <th class="text-center" rowspan="2">JAM KREDIT</th>
                                <th class="text-center" colspan="1">JAM SYARAHAN
                                    <small><a data-toggle="tooltip" data-placement="top" title="Per Semester (Face-to-face)">
                                            <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                        </a></small>
                                </th>
                                <th class="text-center" colspan="1">JAM TUTORIAL
                                    <small><a data-toggle="tooltip" data-placement="top" title="Per Semester (Face-to-face)">
                                            <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                        </a></small></th>
                                <th class="text-center" colspan="1">JAM MAKMAL / LAIN-LAIN
                                    <small><a data-toggle="tooltip" data-placement="top" title="Per Semester (Face-to-face)">
                                            <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                        </a></small></th>
                                <th class="text-center" rowspan="2">TEACHING FILE</th>

                                <th class="text-center" rowspan="2">JENIS SYARAHAN</th>
                                <th class="text-center" rowspan="2">BIL. PENGAJAR BERSAMA<br><sub>(Selain PYD)</sub></th>
                                <th class="text-center" rowspan="2">BLENDED LEARNING</th>



                            </tr>
                            <tr>
                                <th class="text-center">Waktu Perdana</th>
                                <th class="text-center">Waktu Perdana</th>
                                <th class="text-center">Waktu Perdana</th>
                            </tr>

                            <?php if (empty($data)) { ?>
                                <tr>
                                    <td colspan="17">Tiada rekod dijumpai.</td>


                                    <?php } else {

                                    foreach ($input as $ind => $inp) {
                                        if (!isset($data[$inp->ref_id])) {
                                            continue;
                                        }
                                    ?>
                                <tr>
                                    <td class="col-md-1 text-center" style="text-align:center"><?= $abc++; ?> <?= ($data[$inp->ref_id]['DISPLAY'] == 1 && $lpp->PYD == Yii::$app->user->identity->ICNO && $lpp->PYD_sah == 0  and (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat)
                                                                                                                    or ($data[$inp->ref_id]['DISPLAY'] == 1 and $lpp->PYD == \Yii::$app->user->identity->ICNO  and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))) ? Html::button('<i class="fa fa-edit"></i>', ['value' => Url::toRoute(['elnpt/update-pnp', 'id' => $data[$inp->ref_id]['AutoId'], 'lppid' => $lpp->lpp_id]), 'class' => 'btn btn-warning btn-xs modalButton']) . Html::a('<i class="fa fa-trash"></i>', ['elnpt/delete-pnp', 'id' => $data[$inp->ref_id]['AutoId'], 'lppid' => $lpp->lpp_id], ['class' => 'btn btn-danger btn-xs']) : '' ?> <?= ($data[$inp->ref_id]['DISPLAY'] == 1 && $lpp->PYD != Yii::$app->user->identity->ICNO) ? '*' : '' ?></td>

                                    <td class="col-md-1 text-center" style="text-align:center">
                                        <?= $inp->pppSah; ?>
                                    </td>

                                    <td class="col-md-1 text-center" style="text-align:center"><?= $data[$inp->ref_id]['SMP07_KodMP']; ?></td>
                                    <td class="col-md-2"><?= $data[$inp->ref_id]['NAMAKURSUS']; ?></td>
                                    <td class="col-md-1 text-center" style="text-align:center"><?= $data[$inp->ref_id]['BILPELAJAR']; ?></td>
                                    <td class="col-md-1 text-center" style="text-align:center"><?= $data[$inp->ref_id]['SEKSYEN']; ?></td>
                                    <td class="col-md-1 text-center" style="text-align:center"><?= $data[$inp->ref_id]['SESI']; ?></td>
                                    <td class="col-md-1 text-center" style="text-align:center"><?= $data[$inp->ref_id]['JAMKREDIT']; ?></td>
                                    <td class="col-md-1 text-center" style="text-align:center"><?= $inp->waktu_perdana_s; ?></td>

                                    <td class="col-md-1 text-center" style="text-align:center"><?= $inp->waktu_perdana_t; ?></td>

                                    <td class="col-md-1 text-center" style="text-align:center"><?= $inp->waktu_perdana_m; ?></td>

                                    <td class="col-md-1 text-center" style="text-align:center">
                                        <?=
                                            $inp->teachingFileDesc;
                                        ?>
                                    </td>

                                    <td class="col-md-1 text-center" style="text-align:center">
                                        <?=
                                            $inp->jenisSyarahan;
                                        ?>
                                    </td>
                                    <td class="col-md-1 text-center" style="text-align:center">
                                        <?=
                                            $inp->bilPengajar;
                                        ?>
                                    </td>
                                    <td class="col-md-1 text-center" style="text-align:center">
                                        <?php if (isset($data[$inp->ref_id]['status'])) { ?>
                                            <?= ($data[$inp->ref_id]['status'] == 1) ? '<font color="green">PASS</font>' :
                                                '<font color="red">FAIL</font>'; ?>
                                        <?php } else {
                                            echo '<font color="orange">UNAVAILABLE</font>';
                                        }
                                        ?>
                                    </td>





                                </tr>
                            <?php } ?>




                        <?php } ?>


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Aspek Penilaian</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center">Aspek Penilaian</th>
                                <th class="text-center col-md-2">Markah PYD</th>
                                <th class="text-center col-md-2">Markah PPP</th>
                                <th class="text-center col-md-2">Markah PPK</th>
                            </tr>
                            <?php foreach ($mrkh_bhg1 as $ind => $all) { ?>
                                <tr>
                                    <th><?= $all['desc']; ?></th>

                                    <th class="col-md-1 text-center" style="text-align:center"><?= $all['markah_pyd']; ?> <sub><?= ' / ' . $all['pemberat']; ?></sub> </th>

                                    <th class="col-md-1 text-center" style="text-align:center">

                                        <?= is_null($all['markah_ppp']) ? 'PPP' : $all['markah_ppp'] ?> <sub><?= ' / ' . $all['pemberat']; ?></sub>

                                    </th>
                                    <th class="col-md-1 text-center" style="text-align:center">

                                        <?= is_null($all['markah_ppk']) ? 'PPK' : $all['markah_ppk'] ?> <sub><?= ' / ' . $all['pemberat']; ?></sub>

                                    </th>
                                </tr>
                            <?php } ?>

                            <tr>
                                <th style="text-align:right">JUMLAH</th>
                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg1, 'markah_pyd')); ?></th>
                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg1, 'markah_ppp')); ?></th>
                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg1, 'markah_ppk')); ?></th>
                            </tr>

                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Rubrik Pemarkahan</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php foreach ($rubric1 as $ind => $rub) { ?>

                        <strong>Rubrik <?= $ind ?></strong>
                        <p>
                            <table class="table table-sm table-bordered">

                                <tr>
                                    <th>Penilaian</th>

                                    <th class="text-center">Peratus</th>
                                </tr>

                                <?php foreach ($rub as $rb) { ?>
                                    <tr>
                                        <td><?= $rb['penilaian']; ?></td>

                                        <td class="text-center" style="text-align:center"><?= $rb['peratus']; ?></td>
                                    </tr>
                                <?php } ?>

                            </table>
                        </p>

                    <?php

                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<pagebreak />

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Bahagian 2 : Penyeliaan</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center" rowspan="3">BIL.</th>
                                <th class="text-center col-md-4" rowspan="3">TAHAP PENYELIAAN</th>
                                <th class="text-center" colspan="4">BILANGAN PELAJAR DISELIA YANG AKTIF (TERKUMPUL)</th>
                            </tr>
                            <tr>
                                <th class="text-center" colspan="2">SEBAGAI PENYELIA UTAMA/PENGERUSI</th>
                                <th class="text-center" colspan="2">SEBAGAI PENYELIA BERSAMA/AHLI</th>
                            </tr>
                            <tr>
                                <th class="text-center">TELAH PERLANJUTAN</th>
                                <th class="text-center">BELUM PERLANJUTAN</th>
                                <th class="text-center">TELAH PERLANJUTAN</th>
                                <th class="text-center">BELUM PERLANJUTAN</th>
                            </tr>

                            <?php
                            $abc = 1;
                            foreach ($data2 as $dt) {
                                if ($dt['LevelPengajian'] == '1' or $dt['LevelPengajian'] == '2')
                                    continue;
                            ?>
                                <tr>
                                    <td class="text-center"><?= $abc++; ?></td>
                                    <td><?php
                                        switch ($dt['LevelPengajian']) {
                                            case 'PHD':
                                                echo 'PhD (Penyelidikan)';
                                                break;
                                            case 'MASTER':
                                                echo 'Sarjana (Penyelidikan)';
                                                break;
                                            case 'M.Phil.':
                                                echo 'DrPH (Doctor of Public Health)';
                                                break;
                                            default:
                                                echo $dt['LevelPengajian'] . ' - <b>Penyeliaan Luar</b>';
                                                break;
                                        }
                                        ?> <?= ($dt['id'] > 0 && $lpp->PYD == Yii::$app->user->identity->ICNO && $lpp->PYD_sah == 0 and (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat)
                                                or ($dt['id'] > 0 && $lpp->PYD == \Yii::$app->user->identity->ICNO  and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))) ? Html::button('<i class="fa fa-edit"></i>', ['value' => Url::toRoute(['elnpt/update-penyeliaan', 'id' => $dt['id'], 'lppid' => $lpp->lpp_id]), 'class' => 'btn btn-warning btn-xs modalButton']) . Html::a('<i class="fa fa-trash"></i>', ['elnpt/delete-penyeliaan', 'id' => $dt['id'], 'lppid' => $lpp->lpp_id], ['class' => 'btn btn-danger btn-xs']) : '' ?>
                                        <?= ($dt['id'] > 0 && $lpp->PYD != Yii::$app->user->identity->ICNO) ? '*' : '' ?></td>
                                    <td class="text-center"><?= $dt['utama_telah']; ?></td>
                                    <td class="text-center"><?= $dt['utama_belum']; ?></td>
                                    <td class="text-center"><?= $dt['sama_telah']; ?></td>
                                    <td class="text-center"><?= $dt['sama_belum']; ?></td>
                                </tr>
                            <?php } ?>

                            <?php
                            $cnt = 1;
                            foreach ($input2 as $ind => $inp) {

                                echo  $input2[0]['utama_telah'];
                            ?>
                                <tr>
                                    <td class="text-center"><?= $abc; ?></td>
                                    <td><?= ($cnt == 1) ? 'Sarjana (Kerja Kursus)' : 'Sarjana Muda (Projek Tahun Akhir/ Latihan Industri/ Latihan Amali/ Praktikum)' ?></td>
                                    <td class="text-center"><?= is_null($input2[$ind]['utama_telah']) ? 0 : $input2[$ind]['utama_telah']; ?></td>
                                    <td class="text-center"><?= is_null($input2[$ind]['utama_belum']) ? 0 : $input2[$ind]['utama_belum']; ?></td>
                                    <td class="text-center"><?= is_null($input2[$ind]['sama_telah']) ? 0 : $input2[$ind]['sama_telah'];  ?></td>
                                    <td class="text-center"><?= is_null($input2[$ind]['sama_belum']) ? 0 : $input2[$ind]['sama_belum']; ?></td>
                                </tr>

                            <?php
                                $cnt++;
                                $abc++;
                            } ?>


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Aspek Penilaian</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center">Aspek Penilaian</th>
                                <th class="text-center col-md-2">Markah PYD</th>
                                <th class="text-center col-md-2">Markah PPP</th>
                                <th class="text-center col-md-2">Markah PPK</th>
                            </tr>
                            <?php foreach ($mrkh_bhg2 as $ind => $all) { ?>
                                <tr>
                                    <th><?= $all['desc']; ?></th>

                                    <th class="col-md-1 text-center" style="text-align:center"><?= $all['markah_pyd']; ?> <sub><?= ' / ' . $all['pemberat']; ?></sub> </th>

                                    <th class="col-md-1 text-center" style="text-align:center">

                                        <?= is_null($all['markah_ppp']) ? 'PPP' : $all['markah_ppp'] ?> <sub><?= ' / ' . $all['pemberat']; ?></sub>

                                    </th>
                                    <th class="col-md-1 text-center" style="text-align:center">

                                        <?= is_null($all['markah_ppk']) ? 'PPK' : $all['markah_ppk'] ?> <sub><?= ' / ' . $all['pemberat']; ?></sub>

                                    </th>
                                </tr>
                            <?php } ?>

                            <tr>
                                <th style="text-align:right">JUMLAH</th>
                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg2, 'markah_pyd')); ?></th>
                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg2, 'markah_ppp')); ?></th>
                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg2, 'markah_ppk')); ?></th>
                            </tr>

                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Rubrik Pemarkahan</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php foreach ($rubric2 as $ind => $rub) { ?>

                        <strong>Rubrik <?= $ind ?></strong>
                        <p>
                            <table class="table table-sm table-bordered">

                                <tr>
                                    <th>Penilaian</th>

                                    <th class="text-center">Peratus</th>
                                </tr>

                                <?php foreach ($rub as $rb) { ?>
                                    <tr>
                                        <td><?= $rb['penilaian']; ?></td>

                                        <td class="text-center" style="text-align:center"><?= $rb['peratus']; ?></td>
                                    </tr>
                                <?php } ?>

                            </table>
                        </p>

                    <?php

                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<pagebreak />

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Bahagian 3 : Penyelidikan</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">

                            <tr>
                                <th class="text-center">BIL.</th>
                                <th class="text-center">PROJEK ID</th>
                                <th class="text-center col-md-4">TAJUK PROJEK</th>
                                <th class="text-center">PERANAN</th>
                                <th class="text-center col-md-2">PEMBIAYA</th>
                                <th class="text-center col-md-2">KATEGORI PEMBIAYA</th>
                                <th class="text-center col-md-2">JUMLAH BIAYA (RM)</th>
                                <th class="text-center">MULA</th>
                                <th class="text-center">TAMAT</th>
                                <th class="text-center">STATUS</th>
                            </tr>
                            <?php 
                            $sum = 0; 
                            if (empty($data3)) { ?>
                                <tr>
                                    <td colspan="10">Tiada rekod dijumpai.</td>
                                </tr>
                                <?php } else {
                                
                                foreach ($data3 as $ind => $dt) { ?>
                                    <tr>
                                        <td class="col-md-1 text-center" style="text-align:center"><?= $ind + 1; ?> <?= ($dt['Display'] == 1 && $lpp->PYD == Yii::$app->user->identity->ICNO  && $lpp->PYD_sah == 0 and (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat)
                                                                                                                        or ($dt['Display'] == 1 and $lpp->PYD == \Yii::$app->user->identity->ICNO  and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))) ? Html::button('<i class="fa fa-edit"></i>', ['value' => Url::toRoute(['elnpt/update-penyelidikan', 'id' => $dt['ID'], 'lppid' => $lpp->lpp_id]), 'class' => 'btn btn-warning btn-xs modalButton']) . Html::a('<i class="fa fa-trash"></i>', ['elnpt/delete-penyelidikan', 'id' => $dt['ID'], 'lppid' => $lpp->lpp_id], ['class' => 'btn btn-danger btn-xs']) : '' ?>
                                            <?= ($dt['Display'] == 1 && $lpp->PYD != Yii::$app->user->identity->ICNO) ? '*' : '' ?></td>
                                        <td class="col-md-1 text-center" style="text-align:center"><?= $dt['ProjectID']; ?></td>
                                        <td class="col-md-2"><?= $dt['Title']; ?></td>
                                        <td class="col-md-1 text-center" style="text-align:center"><?= $dt['Peranan']; ?></td>
                                        <td class="col-md-1 text-center"><?= $dt['AgencyName']; ?></td>
                                        <td class="col-md-3 text-center"><?php
                                                                            switch ($dt['Tahap_geran']):
                                                                                case '1':
                                                                                    echo 'GERAN UNIVERSITI';
                                                                                    break;
                                                                                case '2':
                                                                                    echo 'GERAN LUAR (TEMPATAN)';
                                                                                    break;
                                                                                case '3':
                                                                                    echo 'GERAN LUAR (ANTARABANGSA)';
                                                                                    break;
                                                                                default:
                                                                                    echo $dt['Tahap_geran'];
                                                                                    break;
                                                                            endswitch;
                                                                            ?></td>
                                        <td class="col-md-1 text-center" style="text-align:center"><?= is_null($dt['Amount']) ? 'RM 0' : Yii::$app->formatter->asCurrency($dt['Amount'], 'RM '); ?></td>
                                        <td class="col-md-1 text-center" style="text-align:center"><?= Yii::$app->formatter->asDate($dt['StartDate'], 'yyyy'); ?></td>
                                        <td class="col-md-1 text-center" style="text-align:center"><?= Yii::$app->formatter->asDate($dt['EndDate'], 'yyyy'); ?></td>
                                        <td class="col-md-1 text-center" style="text-align:center"><?= $dt['Status_geran']; ?></td>
                                    </tr>
                            <?php

                                    $sum += $dt['Amount'];
                                }
                            } ?>
                            <tr>
                                <th colspan="6" style="text-align:right">Jumlah Geran</th>
                                <th style="text-align:center"><?= Yii::$app->formatter->asDecimal($sum); ?></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Aspek Penilaian</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center">Aspek Penilaian</th>
                                <th class="text-center col-md-2">Markah PYD</th>
                                <th class="text-center col-md-2">Markah PPP</th>
                                <th class="text-center col-md-2">Markah PPK</th>
                            </tr>
                            <?php foreach ($mrkh_bhg3 as $ind => $all) { ?>
                                <tr>
                                    <th><?= $all['desc']; ?></th>

                                    <th class="col-md-1 text-center" style="text-align:center"><?= $all['markah_pyd']; ?> <sub><?= ' / ' . $all['pemberat']; ?></sub> </th>

                                    <th class="col-md-1 text-center" style="text-align:center">

                                        <?= is_null($all['markah_ppp']) ? 'PPP' : $all['markah_ppp'] ?> <sub><?= ' / ' . $all['pemberat']; ?></sub>

                                    </th>
                                    <th class="col-md-1 text-center" style="text-align:center">

                                        <?= is_null($all['markah_ppk']) ? 'PPK' : $all['markah_ppk'] ?> <sub><?= ' / ' . $all['pemberat']; ?></sub>

                                    </th>
                                </tr>
                            <?php } ?>

                            <tr>
                                <th style="text-align:right">JUMLAH</th>
                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg3, 'markah_pyd')); ?></th>
                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg3, 'markah_ppp')); ?></th>
                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg3, 'markah_ppk')); ?></th>
                            </tr>

                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Rubrik Pemarkahan</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php foreach ($rubric3 as $ind => $rub) { ?>

                        <strong>Rubrik <?= $ind ?></strong>
                        <p>
                            <table class="table table-sm table-bordered">

                                <tr>
                                    <th>Penilaian</th>

                                    <th class="text-center">Peratus</th>
                                </tr>

                                <?php foreach ($rub as $rb) { ?>
                                    <tr>
                                        <td><?= $rb['penilaian']; ?></td>

                                        <td class="text-center" style="text-align:center"><?= $rb['peratus']; ?></td>
                                    </tr>
                                <?php } ?>

                            </table>
                        </p>

                    <?php

                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<pagebreak />

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Bahagian 4 : Penerbitan</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">

                            <tr>
                                <th class="text-center">BIL.</th>
                                <th class="text-center">JENIS PENERBITAN</th>
                                <th class="text-center">TAJUK</th>
                                <th class="text-center">TAHUN TERBIT</th>
                                <th class="text-center">STATUS PENULIS</th>
                                <th class="text-center">STATUS INDEKS</th>
                                <th class="text-center">STATUS PENERBITAN</th>
                            </tr>
                            <?php if (empty($data4)) { ?>
                                <tr>
                                    <td colspan="9">Penerbitan yang tidak tersenarai sila semak dengan pihak PPPI.</td>
                                </tr>
                                <?php } else {
                                foreach ($data4 as $ind => $dt) { ?>
                                    <tr>
                                        <td class="col-md-1 text-center" style="text-align:center"><?= $ind + 1 ?></td>
                                        <td class="col-md-1 text-center" style="text-align:center"><?= $dt['Bilangan_penerbitan'] ?></td>
                                        <td class="col-md-2"><?= $dt['Title'] ?></td>
                                        <td class="col-md-1 text-center" style="text-align:center"><?= $dt['PublicationYear'] ?></td>
                                        <td class="col-md-1 text-center" style="text-align:center"><?= $dt['Status_penulis'] ?></td>
                                        <td class="col-md-1 text-center" style="text-align:center"><?= $dt['Status_indeks'] ?></td>
                                        <td class="col-md-1 text-center" style="text-align:center"><?php
                                                                                                    echo $dt['Status_penerbitan'];
                                                                                                    ?></td>

                                    </tr>
                            <?php }
                            } ?>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Aspek Penilaian</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center">Aspek Penilaian</th>
                                <th class="text-center col-md-2">Markah PYD</th>
                                <th class="text-center col-md-2">Markah PPP</th>
                                <th class="text-center col-md-2">Markah PPK</th>
                            </tr>
                            <?php foreach ($mrkh_bhg4 as $ind => $all) { ?>
                                <tr>
                                    <th><?= $all['desc']; ?></th>

                                    <th class="col-md-1 text-center" style="text-align:center"><?= $all['markah_pyd']; ?> <sub><?= ' / ' . $all['pemberat']; ?></sub> </th>

                                    <th class="col-md-1 text-center" style="text-align:center">

                                        <?= is_null($all['markah_ppp']) ? 'PPP' : $all['markah_ppp'] ?> <sub><?= ' / ' . $all['pemberat']; ?></sub>

                                    </th>
                                    <th class="col-md-1 text-center" style="text-align:center">

                                        <?= is_null($all['markah_ppk']) ? 'PPK' : $all['markah_ppk'] ?> <sub><?= ' / ' . $all['pemberat']; ?></sub>

                                    </th>
                                </tr>
                            <?php } ?>

                            <tr>
                                <th style="text-align:right">JUMLAH</th>
                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg4, 'markah_pyd')); ?></th>
                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg4, 'markah_ppp')); ?></th>
                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg4, 'markah_ppk')); ?></th>
                            </tr>

                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Rubrik Pemarkahan</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php foreach ($rubric4 as $ind => $rub) { ?>

                        <strong>Rubrik <?= $ind ?></strong>
                        <p>
                            <table class="table table-sm table-bordered">

                                <tr>
                                    <th>Penilaian</th>

                                    <th class="text-center">Peratus</th>
                                </tr>

                                <?php foreach ($rub as $rb) { ?>
                                    <tr>
                                        <td><?= $rb['penilaian']; ?></td>

                                        <td class="text-center" style="text-align:center"><?= $rb['peratus']; ?></td>
                                    </tr>
                                <?php } ?>

                            </table>
                        </p>

                    <?php

                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<pagebreak />

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Bahagian 5 : Persidangan dan Inovasi</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">

                            <tr>
                                <th class="text-center">BIL.</th>
                                <th class="text-center">KATEGORI</th>
                                <th class="text-center">NAMA PERSIDANGAN / INOVASI</th>
                                <th class="text-center">PERANAN</th>
                                <th class="text-center">TAHAP PENYERTAAN</th>
                                <th class="text-center">AMAUN PENGKOMERSIALAN</th>
                            </tr>
                            <?php if (empty($data5)) { ?>
                                <tr>
                                    <td colspan="6">Tiada rekod dijumpai.</td>
                                </tr>
                                <?php } else {
                                foreach ($data5 as $ind => $dt) { ?>
                                    <tr>
                                        <td class="text-center col-md-1" style="text-align:center"><?= $ind + 1; ?></td>
                                        <td class="col-md-1 text-center"><?= $dt['Bilangan_Persidangan_dan_Inovasi']; ?></td>
                                        <td class="col-md-5"><?= $dt['ConferenceTitle']; ?></td>
                                        <td class="col-md-1 text-center" style="text-align:center"><?= $dt['Peranan_dalam_projek_Inovasi']; ?></td>
                                        <td class="col-md-1 text-center"><?= $dt['Tahap_penyertaan']; ?></td>
                                        <td class="col-md-1 text-center"><?= $dt['Amaun_pengkomersialan']; ?></td>
                                    </tr>
                            <?php }
                            } ?>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Aspek Penilaian</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center">Aspek Penilaian</th>
                                <th class="text-center col-md-2">Markah PYD</th>
                                <th class="text-center col-md-2">Markah PPP</th>
                                <th class="text-center col-md-2">Markah PPK</th>
                            </tr>
                            <?php foreach ($mrkh_bhg5 as $ind => $all) { ?>
                                <tr>
                                    <th><?= $all['desc']; ?></th>

                                    <th class="col-md-1 text-center" style="text-align:center"><?= $all['markah_pyd']; ?> <sub><?= ' / ' . $all['pemberat']; ?></sub> </th>

                                    <th class="col-md-1 text-center" style="text-align:center">

                                        <?= is_null($all['markah_ppp']) ? 'PPP' : $all['markah_ppp'] ?> <sub><?= ' / ' . $all['pemberat']; ?></sub>

                                    </th>
                                    <th class="col-md-1 text-center" style="text-align:center">

                                        <?= is_null($all['markah_ppk']) ? 'PPK' : $all['markah_ppk'] ?> <sub><?= ' / ' . $all['pemberat']; ?></sub>

                                    </th>
                                </tr>
                            <?php } ?>

                            <tr>
                                <th style="text-align:right">JUMLAH</th>
                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg5, 'markah_pyd')); ?></th>
                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg5, 'markah_ppp')); ?></th>
                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg5, 'markah_ppk')); ?></th>
                            </tr>

                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Rubrik Pemarkahan</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php foreach ($rubric5 as $ind => $rub) { ?>

                        <strong>Rubrik <?= $ind ?></strong>
                        <p>
                            <table class="table table-sm table-bordered">

                                <tr>
                                    <th>Penilaian</th>

                                    <th class="text-center">Peratus</th>
                                </tr>

                                <?php foreach ($rub as $rb) { ?>
                                    <tr>
                                        <td><?= $rb['penilaian']; ?></td>

                                        <td class="text-center" style="text-align:center"><?= $rb['peratus']; ?></td>
                                    </tr>
                                <?php } ?>

                            </table>
                        </p>

                    <?php

                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<pagebreak />

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Bahagian 6 : Outreaching</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">

                            <tr>
                                <th class="text-center">BIL.</th>
                                <th class="text-center">KATEGORI PERUNDINGAN</th>
                                <th class="text-center">NAMA PROJEK/AKTIVITI</th>
                                <th class="text-center">PERANAN</th>
                                <th class="text-center">TAHAP PENYERTAAN</th>
                                <th class="text-center">AMAUN GERAN</th>
                            </tr>
                            <?php if (empty($data6)) { ?>
                                <tr>
                                    <td colspan="6">Tiada rekod dijumpai.</td>
                                </tr>
                                <?php } else {
                                foreach ($data6 as $ind => $dt) { ?>
                                    <tr>
                                        <td class="col-md-1 text-center" style="text-align:center"><?= $ind + 1 ?> <?= ($dt['id'] != '0' && $lpp->PYD == Yii::$app->user->identity->ICNO && $lpp->PYD_sah == 0 and (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat)
                                                                                                                        or ($dt['id'] != '0' and $lpp->PYD == \Yii::$app->user->identity->ICNO)) ? Html::button('<i class="fa fa-edit"></i>', ['value' => Url::toRoute(['elnpt/update-outreaching', 'id' => $dt['id'], 'lppid' => $lpp->lpp_id]), 'class' => 'btn btn-warning btn-xs modalButton']) . Html::a('<i class="fa fa-trash"></i>', ['elnpt/delete-outreaching', 'id' => $dt['id'], 'lppid' => $lpp->lpp_id], ['class' => 'btn btn-danger btn-xs']) : '' ?>
                                            <?= ($dt['id'] != '0' && $lpp->PYD != Yii::$app->user->identity->ICNO) ? '*' : '' ?></td>
                                        <td class="col-md-1 text-center" style="text-align:center"><?= $dt['Bilangan_outreaching']; ?></td>
                                        <td class="col-md-2 "><?= $dt['Title']; ?></td>
                                        <td class="col-md-2 text-center"><?= $dt['Peranan_outreaching']; ?></td>
                                        <td class="col-md-1 text-center"><?= $dt['Tahap_outreaching']; ?></td>
                                        <td class="col-md-1 text-center"><?= is_numeric($dt['Amaun_outreaching']) ? Yii::$app->formatter->asCurrency($dt['Amaun_outreaching'], 'RM ') : $dt['Amaun_outreaching']; ?></td>
                                    </tr>
                            <?php }
                            } ?>

                        </table>
                    </div>
                </div>
                <div class="row">
                    <p>* Kursus yang ditambah secara manual oleh PYD.</p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Aspek Penilaian</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center">Aspek Penilaian</th>
                                <th class="text-center col-md-2">Markah PYD</th>
                                <th class="text-center col-md-2">Markah PPP</th>
                                <th class="text-center col-md-2">Markah PPK</th>
                            </tr>
                            <?php foreach ($mrkh_bhg6 as $ind => $all) { ?>
                                <tr>
                                    <th><?= $all['desc']; ?></th>

                                    <th class="col-md-1 text-center" style="text-align:center"><?= $all['markah_pyd']; ?> <sub><?= ' / ' . $all['pemberat']; ?></sub> </th>

                                    <th class="col-md-1 text-center" style="text-align:center">

                                        <?= is_null($all['markah_ppp']) ? 'PPP' : $all['markah_ppp'] ?> <sub><?= ' / ' . $all['pemberat']; ?></sub>

                                    </th>
                                    <th class="col-md-1 text-center" style="text-align:center">

                                        <?= is_null($all['markah_ppk']) ? 'PPK' : $all['markah_ppk'] ?> <sub><?= ' / ' . $all['pemberat']; ?></sub>

                                    </th>
                                </tr>
                            <?php } ?>

                            <tr>
                                <th style="text-align:right">JUMLAH</th>
                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg6, 'markah_pyd')); ?></th>
                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg6, 'markah_ppp')); ?></th>
                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg6, 'markah_ppk')); ?></th>
                            </tr>

                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Rubrik Pemarkahan</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php foreach ($rubric6 as $ind => $rub) { ?>

                        <strong>Rubrik <?= $ind ?></strong>
                        <p>
                            <table class="table table-sm table-bordered">

                                <tr>
                                    <th>Penilaian</th>

                                    <th class="text-center">Peratus</th>
                                </tr>

                                <?php foreach ($rub as $rb) { ?>
                                    <tr>
                                        <td><?= $rb['penilaian']; ?></td>

                                        <td class="text-center" style="text-align:center"><?= $rb['peratus']; ?></td>
                                    </tr>
                                <?php } ?>

                            </table>
                        </p>

                    <?php

                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<pagebreak />

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Bahagian 7 : Pengurusan dan Pentadbiran</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">

                            <tr>
                                <th class="text-center">BIL.</th>
                                <th class="text-center">KATEGORI JAWATANKUASA</th>
                                <th class="text-center">NAMA JAWATANKUASA</th>
                                <th class="text-center">PERANAN</th>
                                <th class="text-center">TAHAP LANTIKAN</th>
                            </tr>
                            <?php if (empty($data7)) { ?>
                                <tr>
                                    <td colspan="5">Tiada rekod dijumpai.</td>
                                </tr>
                                <?php } else {
                                foreach ($data7 as $ind => $dt) { ?>
                                    <tr>
                                        <td class="col-md-1 text-center" style="text-align:center"><?= $ind + 1 ?> <?= ($dt['id'] != '0' && $lpp->PYD == Yii::$app->user->identity->ICNO && $lpp->PYD_sah == 0 and (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat)
                                                                                                                        or ($dt['id'] != '0' and $lpp->PYD == \Yii::$app->user->identity->ICNO)) ? Html::button('<i class="fa fa-edit"></i>', ['value' => Url::toRoute(['elnpt/update-urus-tadbir', 'id' => $dt['id'], 'lppid' => $lpp->lpp_id]), 'class' => 'btn btn-warning btn-xs modalButton']) . Html::a('<i class="fa fa-trash"></i>', ['elnpt/delete-urus-tadbir', 'id' => $dt['id'], 'lppid' => $lpp->lpp_id], ['class' => 'btn btn-danger btn-xs']) : '' ?>
                                            <?= ($dt['id'] != '0' && $lpp->PYD != Yii::$app->user->identity->ICNO) ? '*' : '' ?></td>
                                        <td class="col-md-2 text-center" style="text-align:center"><?= $dt['Bilangan_jawatankuasa']; ?></td>
                                        <td class="col-md-2 "><?= $dt['nama_jawatan']; ?></td>
                                        <td class="col-md-1 text-center"><?= !isset($dt['Peranan_jawatankuasa']) ? '(not set)' : $dt['Peranan_jawatankuasa']; ?></td>
                                        <td class="col-md-1 text-center"><?= !isset($dt['Tahap_jawatankuasa']) ? '(not set)' : $dt['Tahap_jawatankuasa']; ?></td>
                                    </tr>
                            <?php }
                            } ?>

                        </table>
                    </div>
                </div>
                <div class="row">
                    <p>* Jawatankuasa yang ditambah secara manual oleh PYD.</p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Aspek Penilaian</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center">Aspek Penilaian</th>
                                <th class="text-center col-md-2">Markah PYD</th>
                                <th class="text-center col-md-2">Markah PPP</th>
                                <th class="text-center col-md-2">Markah PPK</th>
                            </tr>
                            <?php foreach ($mrkh_bhg7 as $ind => $all) { ?>
                                <tr>
                                    <th><?= $all['desc']; ?></th>

                                    <th class="col-md-1 text-center" style="text-align:center"><?= $all['markah_pyd']; ?> <sub><?= ' / ' . $all['pemberat']; ?></sub> </th>

                                    <th class="col-md-1 text-center" style="text-align:center">

                                        <?= is_null($all['markah_ppp']) ? 'PPP' : $all['markah_ppp'] ?> <sub><?= ' / ' . $all['pemberat']; ?></sub>

                                    </th>
                                    <th class="col-md-1 text-center" style="text-align:center">

                                        <?= is_null($all['markah_ppk']) ? 'PPK' : $all['markah_ppk'] ?> <sub><?= ' / ' . $all['pemberat']; ?></sub>

                                    </th>
                                </tr>
                            <?php } ?>

                            <tr>
                                <th style="text-align:right">JUMLAH</th>
                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg7, 'markah_pyd')); ?></th>
                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg7, 'markah_ppp')); ?></th>
                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg7, 'markah_ppk')); ?></th>
                            </tr>

                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Rubrik Pemarkahan</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php foreach ($rubric7 as $ind => $rub) { ?>

                        <strong>Rubrik <?= $ind ?></strong>
                        <p>
                            <table class="table table-sm table-bordered">

                                <tr>
                                    <th>Penilaian</th>

                                    <th class="text-center">Peratus</th>
                                </tr>

                                <?php foreach ($rub as $rb) { ?>
                                    <tr>
                                        <td><?= $rb['penilaian']; ?></td>

                                        <td class="text-center" style="text-align:center"><?= $rb['peratus']; ?></td>
                                    </tr>
                                <?php } ?>

                            </table>
                        </p>

                    <?php

                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<pagebreak />

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Bahagian 8 : Kepimpinan Akademik</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">

                            <tr>
                                <th class="text-center">BIL.</th>
                                <th class="text-center">KATEGORI KEPIMPINAN</th>
                                <th class="text-center">SUMBER INPUT</th>
                                <th class="text-center">BILANGAN</th>
                            </tr>
                            <?php
                            if (empty($data8)) {
                            ?>
                                <tr>
                                    <td colspan="6">Tiada rekod dijumpai.</td>
                                </tr>
                                <?php } else {
                                $cnt = 1;
                                foreach ($data8 as $ind => $dt) { ?>
                                    <tr>
                                        <td class="text-center"><?= $cnt; ?></td>
                                        <td><?= $dt['aspek']; ?></td>
                                        <td class="text-center"><?= $dt['sumber']; ?></td>
                                        <td class="text-center"><?= $dt['skor']; ?></td>
                                    </tr>
                            <?php $cnt++;
                                }
                            } ?>

                        </table>
                    </div>
                </div>

                <div class="row">
                    <p>*Mentoring terpakai untuk DG52/DS53/DU56 dan ke atas sahaja.</p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Aspek Penilaian</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center">Aspek Penilaian</th>
                                <th class="text-center col-md-2">Markah PYD</th>
                                <th class="text-center col-md-2">Markah PPP</th>
                                <th class="text-center col-md-2">Markah PPK</th>
                            </tr>
                            <?php foreach ($mrkh_bhg8 as $ind => $all) { ?>
                                <tr>
                                    <th><?= $all['desc']; ?></th>

                                    <th class="col-md-1 text-center" style="text-align:center"><?= $all['markah_pyd']; ?> <sub><?= ' / ' . $all['pemberat']; ?></sub> </th>

                                    <th class="col-md-1 text-center" style="text-align:center">

                                        <?= is_null($all['markah_ppp']) ? 'PPP' : $all['markah_ppp'] ?> <sub><?= ' / ' . $all['pemberat']; ?></sub>

                                    </th>
                                    <th class="col-md-1 text-center" style="text-align:center">

                                        <?= is_null($all['markah_ppk']) ? 'PPK' : $all['markah_ppk'] ?> <sub><?= ' / ' . $all['pemberat']; ?></sub>

                                    </th>
                                </tr>
                            <?php } ?>

                            <tr>
                                <th style="text-align:right">JUMLAH</th>
                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg8, 'markah_pyd')); ?></th>
                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg8, 'markah_ppp')); ?></th>
                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg8, 'markah_ppk')); ?></th>
                            </tr>

                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Rubrik Pemarkahan</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php foreach ($rubric8 as $ind => $rub) { ?>

                        <strong>Rubrik <?= $ind ?></strong>
                        <p>
                            <table class="table table-sm table-bordered">

                                <tr>
                                    <th>Penilaian</th>

                                    <th class="text-center">Peratus</th>
                                </tr>

                                <?php foreach ($rub as $rb) { ?>
                                    <tr>
                                        <td><?= $rb['penilaian']; ?></td>

                                        <td class="text-center" style="text-align:center"><?= $rb['peratus']; ?></td>
                                    </tr>
                                <?php } ?>

                            </table>
                        </p>

                    <?php

                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<pagebreak />

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Bahagian 9 : Kualiti Peribadi</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">

                            <tr>
                                <th class="text-center" rowspan="2">BIL.</th>
                                <th class="text-center" rowspan="2">KATEGORI KUALITI</th>
                                <th class="text-center" colspan="3">SUMBER INPUT</th>
                            </tr>
                            <tr>
                                <th class="text-center">PPP <sub>/ 100%</sub></th>
                                <th class="text-center">PPK <sub>/ 100%</sub></th>
                                <th class="text-center">PEER <sub>/ 100%</sub></th>
                            </tr>
                            <?php
                            $abc = 1;
                            foreach ($input9 as $ind => $inp) { ?>
                                <tr>
                                    <td class="col-md-1 text-center" style="text-align:center"><?= $abc ?></td>
                                    <td><?= $data9[$inp->ref_kualiti_id]['aspek']; ?></td>
                                    <td class="col-md-1 text-center"><?= ($lpp->PPP == Yii::$app->user->identity->ICNO && ($lpp->PYD_sah == 1) && ($lpp->PPP_sah == 0) and (date('Y-m-d H:i:s') <= $tahun->penilaian_PPP_tamat)) ? $form->field($inp, "[$ind]markah_ppp")->textInput(['type' => 'number', 'min' => 0, 'max' => 100, 'step' => '0.01', 'style' => 'text-align:center', 'placeholder' => '0.0'])->label(false) : (($lpp->PPP == Yii::$app->user->identity->ICNO or $lpp->PPK == Yii::$app->user->identity->ICNO or app\models\elnpt\testing\TblTestingAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])->exists()) ? $inp->markah_ppp : 'PPP'); ?></td>
                                    <td class="col-md-1 text-center"><?= ($lpp->PPK == Yii::$app->user->identity->ICNO && ($lpp->PYD_sah == 1) && ($lpp->PPK_sah == 0) and (date('Y-m-d H:i:s') <= $tahun->penilaian_PPK_tamat)) ? $form->field($inp, "[$ind]markah_ppk")->textInput(['type' => 'number', 'min' => 0, 'max' => 100, 'step' => '0.01', 'style' => 'text-align:center', 'placeholder' => '0.0'])->label(false) : (($lpp->PPK == Yii::$app->user->identity->ICNO or app\models\elnpt\testing\TblTestingAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])->exists()) ? $inp->markah_ppk : 'PPK'); ?></td>
                                    <td class="col-md-1 text-center"><?= ($lpp->PEER == Yii::$app->user->identity->ICNO && ($lpp->PYD_sah == 1) && ($lpp->PEER_sah == 0) and (date('Y-m-d H:i:s') <= $tahun->penilaian_PEER_tamat)) ? $form->field($inp, "[$ind]markah_peer")->textInput(['type' => 'number', 'min' => 0, 'max' => 100, 'step' => '0.01', 'style' => 'text-align:center', 'placeholder' => '0.0'])->label(false) : (($lpp->PEER == Yii::$app->user->identity->ICNO or app\models\elnpt\testing\TblTestingAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])->exists()) ? $inp->markah_peer : 'PEER'); ?></td>
                                </tr>
                            <?php
                                $abc++;
                            } ?>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Aspek Penilaian</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center">Aspek Penilaian</th>
                                <th class="text-center col-md-2">Markah PPP</th>
                                <th class="text-center col-md-2">Markah PPP</th>
                                <th class="text-center col-md-2">Markah PEER</th>
                            </tr>
                            <?php foreach ($mrkh_bhg9 as $ind => $all) { ?>
                                <tr>
                                    <th><?= $all['desc']; ?></th>

                                    <th class="col-md-1 text-center" style="text-align:center">

                                        <?= is_null($all['markah_ppp']) ? 'PPP' : $all['markah_ppp'] ?> <sub><?= ' / ' . $all['pemberat']; ?></sub>

                                    </th>
                                    <th class="col-md-1 text-center" style="text-align:center">

                                        <?= is_null($all['markah_ppk']) ? 'PPK' : $all['markah_ppk'] ?> <sub><?= ' / ' . $all['pemberat']; ?></sub>

                                    </th>
                                    <th class="col-md-1 text-center" style="text-align:center">

                                        <?= is_null($all['markah_peer']) ? 'PEER' : $all['markah_peer'] ?> <sub><?= ' / ' . $all['pemberat']; ?></sub>

                                    </th>
                                </tr>
                            <?php } ?>

                            <tr>
                                <th style="text-align:right">JUMLAH</th>

                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg9, 'markah_ppp')); ?></th>
                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg9, 'markah_ppk')); ?></th>
                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg9, 'markah_peer')); ?></th>
                            </tr>

                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Rubrik Pemarkahan</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php foreach ($rubric9 as $ind => $rub) { ?>

                        <strong>Rubrik <?= $ind ?></strong>
                        <p>
                            <table class="table table-sm table-bordered">

                                <tr>
                                    <th>Penilaian</th>

                                    <th class="text-center">Peratus</th>
                                </tr>

                                <?php foreach ($rub as $rb) { ?>
                                    <tr>
                                        <td><?= $rb['penilaian']; ?></td>

                                        <td class="text-center" style="text-align:center"><?= $rb['peratus']; ?></td>
                                    </tr>
                                <?php } ?>

                            </table>
                        </p>

                    <?php

                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<pagebreak />

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong>Markah Keseluruhan</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="table-responsive">
                        <div class="col-md-9">
                            <?= ChartJs::widget([
                                'type' => 'radar',
                                'id' => 'structureDoughnut',
                                'options' => [
                                    'height' => 300,
                                    'width' => 500,
                                ],
                                'data' => [
                                    //'radius' =>  "90%",
                                    'labels' => array_values(ArrayHelper::getColumn($markah, 'aspek')),
                                    'datasets' => [
                                        [
                                            'data' => array_values(ArrayHelper::getColumn($markah, 'markah')),
                                            'label' => '',
                                            'fill' => true,
                                            'backgroundColor' => "rgba(255,99,132,0.2)",
                                            'borderColor' => "rgba(255,99,132,1)",
                                            'pointBorderColor' => "#fff",
                                            'pointBackgroundColor' => "rgba(255,99,132,1)",
                                            //'hoverBorderColor'=>["#999","#999","#999"],                
                                        ]
                                    ]
                                ],
                                'clientOptions' => [
                                    'responsive' => true,
                                    'legend' => [
                                        'display' => false,
                                        'position' => 'bottom',
                                        'labels' => [
                                            'fontSize' => 14,
                                            'fontColor' => "#425062",
                                        ]
                                    ],
                                    'tooltips' => [
                                        //                                    'enabled' => true,
                                        //                                    'intersect' => true,
                                        'callbacks' => [
                                            'label' => new JsExpression("function(t, d) {
                     var label = d.labels[t.index];
                     var data = d.datasets[t.datasetIndex].data[t.index];
                     if (t.datasetIndex === 0)
                     return label + ': ' + data;
                     else if (t.datasetIndex === 1)
                     return label + ': $' + data.toLocaleString();
              }"),
                                            'title' => new JsExpression('function(){}')
                                            //                                        'title' => '',
                                        ]
                                    ],
                                    'hover' => [
                                        'mode' => false
                                    ],
                                    'maintainAspectRatio' => false,
                                    'scale' => [
                                        'ticks' => [
                                            'beginAtZero' => true,
                                            'precision' => 0,
                                            'suggestedMax' => max(array_values(ArrayHelper::getColumn($pemberat, 'pemberat'))),
                                            'stepSize' => 5
                                            //                                        'maxTicksLimit' => 10
                                        ],
                                        //                                    'pointLabels' => [
                                        //                                        'fontColor' => ArrayHelper::getColumn($markah, 'warna')
                                        //                                    ]
                                    ]

                                ],
                            ]);
                            ?>
                        </div>
                        <div class="col-md-3">
                            <?=
                                \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'star',
                                        'header' => 'Kategori',
                                        'text' => strtoupper($kategori),
                                        'number' => $total . '%',
                                    ]
                                )
                            ?>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center"></th>
                                <?php foreach (array_column($mrkh_all, 'bahagian') as $b) { ?>
                                    <th class="text-center"><?= $b; ?></th>
                                <?php } ?>
                                <th class="text-center">Jumlah <sub>(100%)</sub></th>
                            </tr>
                            <tr>
                                <th class="text-center">PYD</th>
                                <?php foreach ($pyd as $ind => $m) {
                                    if ($ind == 9) { ?>
                                        <th class="text-center">-</th>
                                    <?php continue;
                                    } else {
                                    ?>
                                        <th class="text-center"><?= is_null($m['mrkh_bhg']) ? '0<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>' : Yii::$app->formatter->asDecimal($m['mrkh_bhg']) . '<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>'; ?></th>
                                <?php }
                                } ?>
                                <th class="text-center"><?= Yii::$app->formatter->asDecimal(array_sum(array_column($pyd, 'mrkh_bhg'))); ?></th>
                            </tr>
                            <tr>
                                <th class="text-center">PPP</th>
                                <?php foreach ($ppp as $ind => $m) { ?>
                                    <th class="text-center"><?= is_null($m['mrkh_bhg']) ? '0<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>' : Yii::$app->formatter->asDecimal($m['mrkh_bhg']) . '<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>'; ?></th>
                                <?php } ?>
                                <th class="text-center"><?= Yii::$app->formatter->asDecimal(array_sum(array_column($ppp, 'mrkh_bhg'))); ?></th>
                            </tr>
                            <tr>
                                <th class="text-center">PPK</th>
                                <?php foreach ($ppk as $ind => $m) { ?>
                                    <th class="text-center"><?= is_null($m['mrkh_bhg']) ? '0<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>' : Yii::$app->formatter->asDecimal($m['mrkh_bhg']) . '<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>'; ?></th>
                                <?php } ?>
                                <th class="text-center"><?= Yii::$app->formatter->asDecimal(array_sum(array_column($ppk, 'mrkh_bhg'))); ?></th>
                            </tr>
                            <tr>
                                <th class="text-center">Purata (PPP + PPK)</th>
                                <?php foreach ($ppk as $ind => $m) { ?>
                                    <th class="text-center"><?= is_null($markah[$ind]['markah']) ? '0<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>' : $markah[$ind]['markah'] . '<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>'; ?></th>
                                <?php } ?>
                                <th class="text-center"><?= Yii::$app->formatter->asDecimal(array_sum(array_column($markah, 'markah'))); ?></th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<pagebreak />

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong>Ringkasan Markah</strong></h4>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center">Aspek Penilaian</th>

                                <th class="text-center">Markah PYD</th>
                                <th class="text-center">Markah PPP</th>
                                <th class="text-center">Markah PPK</th>
                                <th class="text-center">Markah Peer</th>
                            </tr>
                            <?php
                            $sumPyd = 0;
                            $sumPpp = 0;
                            $sumPpk = 0;
                            $sumPeer = 0;
                            $cnt = 0;
                            foreach ($summary as $ind => $smyy) { ?>
                                <?php foreach ($smyy as $smy) { ?>
                                    <tr>
                                        <td <?= ($smy['desc'] == 'JUMLAH') ? 'align="right"' : '' ?>><?= $smy['desc']; ?></td>

                                        <td class="col-md-1 text-center" style="text-align:center"><?= $smy['markah_pyd']; ?></td>
                                        <td class="col-md-1 text-center" style="text-align:center"><?= $smy['markah_ppp']; ?></td>
                                        <td class="col-md-1 text-center" style="text-align:center"><?= $smy['markah_ppk']; ?></td>
                                        <td class="col-md-1 text-center" style="text-align:center"><?= ($smy['bhg_no'] == 9 or ($smy['desc'] == 'JUMLAH')) ?  $smy['markah_peer'] : '-'; ?></td>
                                    </tr>
                                <?php


                                } ?>
                            <?php

                                $sumPyd = $sumPyd + $smy['markah_pyd'];
                                $sumPpp = $sumPpp + $smy['markah_ppp'];
                                $sumPpk = $sumPpk + $smy['markah_ppk'];
                                $sumPeer = $sumPeer + $smy['markah_peer'];
                                $cnt++;
                            } ?>
                            <tr>
                                <th class="text-center">TOTAL MARKAH KESELURUHAN</th>

                                <th class="text-center">
                                    <math>
                                        <mfrac>
                                            <mn><?= $sumPyd ?></mn>
                                            /
                                            <mn><?= ($cnt * 100) ?></mn>
                                        </mfrac>
                                        <mo>x</mo>
                                        <mn>100%</mn>
                                        <mo>=</mo>
                                        <mn>
                                            <?= \Yii::$app->formatter->asDecimal(($sumPyd / ($cnt * 100) * 100), 2) ?>
                                        </mn>
                                    </math>
                                </th>
                                <th class="text-center">
                                    <math>
                                        <mfrac>
                                            <mn><?= $sumPpp ?></mn>
                                            /
                                            <mn><?= ($cnt * 100) ?></mn>
                                        </mfrac>
                                        <mo>x</mo>
                                        <mn>100%</mn>
                                        <mo>=</mo>
                                        <mn>
                                            <?= \Yii::$app->formatter->asDecimal(($sumPpp / ($cnt * 100) * 100), 2) ?>
                                        </mn>
                                    </math></th>
                                <th class="text-center">
                                    <math>
                                        <mfrac>
                                            <mn><?= $sumPpk ?></mn>
                                            /
                                            <mn><?= ($cnt * 100) ?></mn>
                                        </mfrac>
                                        <mo>x</mo>
                                        <mn>100%</mn>
                                        <mo>=</mo>
                                        <mn>
                                            <?= \Yii::$app->formatter->asDecimal(($sumPpk / ($cnt * 100) * 100), 2) ?>
                                        </mn>
                                    </math></th>
                                <th class="text-center">
                                    <math>
                                        <mfrac>
                                            <mn><?= $sumPeer ?></mn>
                                            /
                                            <mn><?= ($cnt * 100) ?></mn>
                                        </mfrac>
                                        <mo>x</mo>
                                        <mn>100%</mn>
                                        <mo>=</mo>
                                        <mn>
                                            <?= \Yii::$app->formatter->asDecimal(($sumPeer / ($cnt * 100) * 100), 2) ?>
                                        </mn>
                                    </math></th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<pagebreak />

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4><strong> Pengesahan</strong></h4>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h4><strong>Pengesahan Pegawai Yang Dinilai (PYD)</strong></h4>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="row">
                                    <p align="center"><strong>PYD <?= ($lpp->PYD_sah == 1) ? '<font color="green">TELAH</font>' : '<font color="red">BELUM</font>' ?> MEMBUAT PENGESAHAN BORANG eLNPT <?= $lpp->tahun; ?> <?= ($lpp->PYD_sah == 1) ? '(PADA ' . Yii::$app->formatter->asDateTime($lpp->PYD_sah_datetime . ' Asia/Kuala_Lumpur', "php:d/m/Y  h:i A") . ')' : '' ?></strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h4><strong>Pengesahan Pegawai Penilai Pertama (PPP)</strong></h4>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="row">
                                    <p align="center"><strong>PPP <?= ($lpp->PPP_sah == 1) ? '<font color="green">TELAH</font>' : '<font color="red">BELUM</font>' ?> MEMBUAT PENGESAHAN BORANG eLNPT <?= $lpp->tahun; ?> <?= ($lpp->PPP_sah == 1) ? '(PADA ' . Yii::$app->formatter->asDateTime($lpp->PPP_sah_datetime . ' Asia/Kuala_Lumpur', "php:d/m/Y  h:i A") . ')' : '' ?></strong></p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h4><strong>Pengesahan Pegawai Penilai Kedua (PPK)</strong></h4>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="row">
                                    <p align="center"><strong>PPK <?= ($lpp->PPK_sah == 1) ? '<font color="green">TELAH</font>' : '<font color="red">BELUM</font>' ?> MEMBUAT PENGESAHAN BORANG eLNPT <?= $lpp->tahun; ?> <?= ($lpp->PPK_sah == 1) ? '(PADA ' . Yii::$app->formatter->asDateTime($lpp->PPK_sah_datetime . ' Asia/Kuala_Lumpur', "php:d/m/Y  h:i A") . ')' : '' ?></strong></p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h4><strong>Pengesahan PEER</strong></h4>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="row">
                                    <p align="center"><strong>PEER <?= ($lpp->PEER_sah == 1) ? '<font color="green">TELAH</font>' : '<font color="red">BELUM</font>' ?> MEMBUAT PENGESAHAN BORANG eLNPT <?= $lpp->tahun; ?> <?= ($lpp->PEER_sah == 1) ? '(PADA ' . Yii::$app->formatter->asDateTime($lpp->PEER_sah_datetime . ' Asia/Kuala_Lumpur', "php:d/m/Y  h:i A") . ')' : '' ?></strong></p>

                                    <?php if ((($lpp->PEER_sah != 1 and $lpp->PEER == \Yii::$app->user->identity->ICNO) and (date('Y-m-d H:i:s') <= $tahun->penilaian_PEER_tamat))
                                        or ($lpp->PEER == \Yii::$app->user->identity->ICNO  and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))
                                    ) { ?>
                                        <div style="text-align: center">
                                            <?= Html::button('Sahkan', ['value' =>  Url::to(['elnpt/pengesahan-peer', 'lppid' => $lpp->lpp_id]), 'class' => 'btn btn-success btn-sm modalButton']) ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>