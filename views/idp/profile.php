<?php //needed for Html tag usage

use app\widgets\TopMenuWidget;
use yii\helpers\Html;
//use yiister\gentelella\widgets\IdpTileWidget;
use app\widgets\IdpTileWidget;
use yii\bootstrap\Alert;
use app\models\myidp\Kehadiran;
use app\models\myidp\KursusLatihan;
use app\models\myidp\BorangPenilaianLatihanLama;

/* Menu */
//echo TopMenuWidget::widget(['top_menu' => [100, 104, 108, 196], 'vars' => [
//    ['label' => ''],
//]]);

echo $this->render('/idp/_topmenu');

?>
<div class="clearfix"></div>
<div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">

        <div class="x_panel">
            <div class="x_title">
                <h2>PELAN PEMBANGUNAN INDIVIDU <?= $tahun; ?></h2>
                <div class="clearfix"></div>
            </div> <!-- closed div class x_title -->
            <!-- padam div class well -->
            <div class="x_content">

            </div>
        </div> <!-- closed div class x_panel -->
    </div>
    <?php

    if ($staffCategory == 'ADMINISTRATION') {

    ?>
        <div class="col-xs-12 col-md-3">
            <?= IdpTileWidget::widget(
                [
                    'icon' => 'pie-chart',
                    //'icon' => 'fas fa-chart-pie',
                    'header' => 'Teras Universiti',
                    //'text' => '<p class="bg-primary">Kursus wajib universiti</p>',
                    'text' => 'Kursus wajib universiti',
                    'number' => $individualTerasUniversiti . '/' . $minTerasUniversiti,
                    'pbar' => '<div class="' . $uprogressBarColour . ' role="progressbar" data-transitiongoal="' . $percentageTerasUniversiti . '">' . $percentageTerasUniversiti . '%</div>',
                ]
            );
            ?>
        </div>
        <div class="col-xs-12 col-md-3">
            <?= IdpTileWidget::widget(
                [
                    'icon' => 'pie-chart',
                    'header' => 'Teras Skim',
                    'text' => 'Kursus wajib berdasarkan skim',
                    'number' => $individualTerasSkim . '/' . $minTerasSkim,
                    'pbar' => '<div class="' . $sprogressBarColour . ' role="progressbar" data-transitiongoal="' . $percentageTerasSkim . '">' . $percentageTerasSkim . '%</div>',
                ]
            );
            ?>
        </div>
        <div class="col-xs-12 col-md-3">
            <?= IdpTileWidget::widget(
                [
                    'icon' => 'pie-chart',
                    'header' => 'Elektif',
                    'text' => 'Kursus pilihan',
                    'number' => $individualElektif . '/' . $minElektif,
                    'pbar' => '<div class="' . $eprogressBarColour . ' role="progressbar" data-transitiongoal="' . $percentageElektif . '">' . $percentageElektif . '%</div>',
                ]
            );
            ?>
        </div>
        <div class="col-xs-12 col-md-3">
            <?= IdpTileWidget::widget(
                [
                    'icon' => 'pie-chart',
                    'header' => 'Umum',
                    'text' => 'Kursus umum',
                    'number' => $individualUmum,
                    'pbar' => '<div class="' . $mprogressBarColour . ' role="progressbar" data-transitiongoal="100">TIDAK DIKIRA</div>',
                ]
            );
            ?>
        </div>
    <?php } elseif ($staffCategory == 'ACADEMIC') { ?>

        <div class="col-xs-12 col-md-4">
            <?= IdpTileWidget::widget(
                [
                    'icon' => 'pie-chart',
                    //'icon' => 'fas fa-chart-pie',
                    'header' => 'Teras (50%)',
                    //'text' => '<p class="bg-primary">Kursus wajib universiti</p>',
                    'text' => 'Kursus Teras',
                    'number' => $individualTerasAcademic . '/' . $minTerasAcademic,
                    'pbar' => '<div class="' . $taprogressBarColour . ' role="progressbar" data-transitiongoal="' . $percentageTerasAcademic . '">' . $percentageTerasAcademic . '%</div>',
                ]
            );
            ?>
        </div>
        <div class="col-xs-12 col-md-4">
            <?= IdpTileWidget::widget(
                [
                    'icon' => 'pie-chart',
                    'header' => 'Elektif (30%)',
                    'text' => 'Kursus Elektif',
                    'number' => $individualElektifAcademic . '/' . $minElektifAcademic,
                    'pbar' => '<div class="' . $eprogressBarColour . ' role="progressbar" data-transitiongoal="' . $percentageElektif . '">' . $percentageElektif . '%</div>',
                ]
            );
            ?>
        </div>
        <div class="col-xs-12 col-md-4">
            <?= IdpTileWidget::widget(
                [
                    'icon' => 'pie-chart',
                    'header' => 'Umum (20%)',
                    'text' => 'Kursus Umum',
                    'number' => $individualUmumAcademic . '/' . $minUmumAcademic,
                    'pbar' => '<div class="' . $uaprogressBarColour . ' role="progressbar" data-transitiongoal="' . $percentageUmumAcademic . '">' . $percentageUmumAcademic . '%</div>',
                ]
            );
            ?>
        </div>
    <?php } ?>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h5>IDP Semasa</h5>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <!--                            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">-->
                    <table class="table table-sm jambo_table table-bordered" style="text-align:center;">
                        <thead>
                            <tr class="headings">
                                <?php if ($staffCategory == 'ADMINISTRATION') { ?>
                                    <th class="column-title text-center">Mata IDP Minimum Kumpulan</th>
                                    <th class="column-title text-center">Jumlah Mata IDP Semasa</th>
                                    <th class="column-title text-center">Jumlah Mata IDP Yang Diambilkira</th>
                                    <th class="column-title text-center">Sumbangan Kepada Markah LNPT (8%)</th>
                                <?php } elseif ($staffCategory == 'ACADEMIC') { ?>
                                    <th class="column-title text-center">Mata IDP Minimum Kumpulan</th>
                                    <th class="column-title text-center">Jumlah Mata IDP Semasa</th>
                                    <th class="column-title text-center">Jumlah Mata IDP Yang Diambilkira</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php if ($staffCategory == 'ADMINISTRATION') { ?>
                                    <td><?= $modelRpt->idp_mata_min ?></td>
                                    <td><?= $individualTerasUniversiti + $individualTerasSkim + $individualElektif ?></td>
                                    <td><?= $jumlahMataAmbilKira ?></td>
                                    <td><?= $sumbanganlnpt ?></td>
                                <?php } elseif ($staffCategory == 'ACADEMIC') { ?>
                                    <td><?= $modelRpt->idp_mata_min ?></td>
                                    <td><?= $individualTerasAcademic + $individualUmumAcademic + $individualElektifAcademic ?></td>
                                    <td><?= $jumlahMataAmbilKira ?></td>
                                <?php } ?>
                            </tr>
                        </tbody>
                    </table>
                    <!--            <ul>
                <li><span class="label label-warning">Dalam Tindakan KP</span> : Menunggu persetujuan dari Ketua Pentadbiran</li>
                <li><span class="label label-info">Dalam Tindakan KJ</span> : Menunggu perakuan dari Ketua Jabatan</li>
                <li><span class="label label-primary">Dalam Tindakan BSM</span> : Menunggu kelulusan dari BSM</li>
                <li><span class="label label-success">Berjaya</span> : Diluluskan</li> 
                <li><span class="label label-danger">Ditolak</span> : Tidak Diluluskan</li>
            </ul>-->
                </div>
            </div>
        </div>
    </div>
</div>
<div>
    <div>
        <?php if ($staffCategory == 'ADMINISTRATION') { ?>
            <div class="x_panel">
                <div class="x_title">
                    <h5>Wajib Teras Universiti</h5>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div>
                        <?php

                        $bil = 1;
                        ?><?php
                                    if ($teras) { ?>
                        <table class="table table-striped jambo_table">
                            <thead>
                                <tr>
                                    <th class="text-center">Bil</th>
                                    <th class="text-center">Nama Kursus</th>
                                    <th class="text-center">Tarikh Kursus</th>
                                    <th class="text-center">Jumlah Mata</th>
                                    <!--                                                <th class="text-center">Jenis</th>-->
                                    <th class="text-center">Penilaian Kursus</th>
                                </tr>
                            </thead>
                            <?php
                                        foreach ($teras as $lat) {
                                            //echo $lat->latihan->vcsl_nama_latihan . '<br>';
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $bil++ ?></td>
                                    <td class="text-left"><?php echo strtoupper($lat->latihan->vcsl_nama_latihan);
                                                            //$lat->sasaran9->sasaran4->latihan->vcsl_nama_latihan; 
                                                            //echo $lat->vcsl_nama_latihan; 
                                                            ?></td>
                                    <td class="text-center"><?php echo $lat->vcl_tkh_mula; ?></td>
                                    <td class="text-center"><?php echo $lat->vcl_jum_mata; ?></td>
                                    <!--                                                <td class="text-center"><?php //echo KursusLatihan::identifyJenis($lat->kursusLatihanID) 
                                                                                                                ?></td>-->
                                    <td class="text-center">
                                        <?php echo BorangPenilaianLatihanLama::checkBorangStatusp($lat->vcl_kod_latihan, $lat->vcl_id_staf); ?>
                                    </td>
                                </tr>
                            <?php
                                        }
                                    } else { ?>
                            <tr>
                                <td colspan="3" class="align-center text-center"><i>Belum Hadir Latihan</i></td>
                            </tr>
                        <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="x_panel">
                <div class="x_title">
                    <h5>Wajib Teras Skim</h5>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div>
                        <?php

                        $bil = 1;
                        ?><?php
                                    if ($skim) { ?>
                        <table class="table table-striped jambo_table">
                            <thead>
                                <tr>
                                    <th class="text-center">Bil</th>
                                    <th class="text-center">Nama Kursus</th>
                                    <th class="text-center">Tarikh Kursus</th>
                                    <th class="text-center">Jumlah Mata</th>
                                    <!--                                                <th class="text-center">Jenis</th>-->
                                    <th class="text-center">Penilaian Kursus</th>
                                </tr>
                            </thead>
                            <?php
                                        foreach ($skim as $lat) { ?>
                                <tr>
                                    <td class="text-center"><?php echo $bil++ ?></td>
                                    <td class="text-left"><?php echo strtoupper($lat->latihan->vcsl_nama_latihan);
                                                            //$lat->sasaran9->sasaran4->latihan->vcsl_nama_latihan; 
                                                            //echo $lat->vcsl_nama_latihan; 
                                                            ?></td>
                                    <td class="text-center"><?php echo $lat->vcl_tkh_mula; ?></td>
                                    <td class="text-center"><?php echo $lat->vcl_jum_mata; ?></td>
                                    <!--                                                <td class="text-center"><?php //echo KursusLatihan::identifyJenis($lat->kursusLatihanID) 
                                                                                                                ?></td>-->
                                    <td class="text-center">
                                        <?php echo BorangPenilaianLatihanLama::checkBorangStatusp($lat->vcl_kod_latihan, $lat->vcl_id_staf); ?>
                                    </td>
                                </tr>
                            <?php }
                                    } else { ?>
                            <tr>
                                <td colspan="3" class="align-center text-center"><i>Belum Hadir Latihan</i></td>
                            </tr>
                        <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="x_panel">
                <div class="x_title">
                    <h5>Elektif</h5>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div>
                        <?php

                        $bil = 1;
                        ?><?php
                                    if ($elektif) { ?>
                        <table class="table table-striped jambo_table">
                            <thead>
                                <tr>
                                    <th class="text-center">Bil</th>
                                    <th class="text-center">Nama Kursus</th>
                                    <th class="text-center">Tarikh Kursus</th>
                                    <th class="text-center">Jumlah Mata</th>
                                    <!--                                                <th class="text-center">Jenis</th>-->
                                    <th class="text-center">Penilaian Kursus</th>
                                </tr>
                            </thead>
                            <?php
                                        foreach ($elektif as $lat) {
                                            //echo $lat->latihan->vcsl_nama_latihan . '<br>';
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $bil++ ?></td>
                                    <td class="text-left"><?php echo strtoupper($lat->latihan->vcsl_nama_latihan);
                                                            //$lat->sasaran9->sasaran4->latihan->vcsl_nama_latihan; 
                                                            //echo $lat->vcsl_nama_latihan; 
                                                            ?></td>
                                    <td class="text-center"><?php echo $lat->vcl_tkh_mula; ?></td>
                                    <td class="text-center"><?php echo $lat->vcl_jum_mata; ?></td>
                                    <!--                                                <td class="text-center"><?php //echo KursusLatihan::identifyJenis($lat->kursusLatihanID) 
                                                                                                                ?></td>-->
                                    <td class="text-center">
                                        <?php echo BorangPenilaianLatihanLama::checkBorangStatusp($lat->vcl_kod_latihan, $lat->vcl_id_staf); ?>
                                    </td>
                                </tr>
                            <?php
                                        }
                                    } else { ?>
                            <tr>
                                <td colspan="3" class="align-center text-center"><i>Belum Hadir Latihan</i></td>
                            </tr>
                        <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="x_panel">
                <div class="x_title">
                    <h5>Umum</h5>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div>
                        <?php

                        $bil = 1;
                        ?><?php
                                    if ($umum) { ?>
                        <table class="table table-striped jambo_table">
                            <thead>
                                <tr>
                                    <th class="text-center">Bil</th>
                                    <th class="text-center">Nama Kursus</th>
                                    <th class="text-center">Tarikh Kursus</th>
                                    <th class="text-center">Jumlah Mata</th>
                                    <!--                                                <th class="text-center">Jenis</th>-->
                                </tr>
                            </thead>
                            <?php
                                        foreach ($umum as $lat) {
                                            //echo $lat->latihan->vcsl_nama_latihan . '<br>';
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $bil++ ?></td>
                                    <td class="text-left">
                                        <?php
                                            if ($lat->latihan) {
                                                echo strtoupper($lat->latihan->vcsl_nama_latihan);
                                            } else {
                                                echo "";
                                            }

                                            //$lat->sasaran9->sasaran4->latihan->vcsl_nama_latihan; 
                                            //echo $lat->vcsl_nama_latihan; 
                                        ?></td>
                                    <td class="text-center"><?php echo $lat->vcl_tkh_mula; ?></td>
                                    <td class="text-center"><?php echo $lat->vcl_jum_mata; ?></td>
                                    <!--                                                <td class="text-center"><?php //echo KursusLatihan::identifyJenis($lat->kursusLatihanID) 
                                                                                                                ?></td>-->
                                </tr>
                            <?php
                                        }
                                    } else { ?>
                            <tr>
                                <td colspan="3" class="align-center text-center"><i>Belum Hadir Latihan</i></td>
                            </tr>
                        <?php } ?>
                        </table>
                    </div> <!-- ubah sini -->
                </div> <!-- x_content -->
            </div>
        <?php } elseif ($staffCategory == 'ACADEMIC') { ?>
            <div class="x_panel">
                <div class="x_title">
                    <h5>Teras</h5>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div>
                        <?php

                        $bil = 1;
                        ?><?php
                                    if ($teras) { ?>
                        <table class="table table-striped jambo_table">
                            <thead>
                                <tr>
                                    <th class="text-center">Bil</th>
                                    <th class="text-center">Nama Kursus</th>
                                    <th class="text-center">Tarikh Kursus</th>
                                    <th class="text-center">Jumlah Mata</th>
                                    <!--                                                <th class="text-center">Jenis</th>-->
                                    <th class="text-center">Penilaian Kursus</th>
                                </tr>
                            </thead>
                            <?php
                                        foreach ($teras as $lat) {
                                            //echo $lat->latihan->vcsl_nama_latihan . '<br>';
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $bil++ ?></td>
                                    <td class="text-left"><?php echo strtoupper($lat->latihan->vcsl_nama_latihan);
                                                            //$lat->sasaran9->sasaran4->latihan->vcsl_nama_latihan; 
                                                            //echo $lat->vcsl_nama_latihan; 
                                                            ?></td>
                                    <td class="text-center"><?php echo $lat->vcl_tkh_mula; ?></td>
                                    <td class="text-center"><?php echo $lat->vcl_jum_mata; ?></td>
                                    <!--                                                <td class="text-center"><?php //echo KursusLatihan::identifyJenis($lat->kursusLatihanID) 
                                                                                                                ?></td>-->
                                    <td class="text-center">
                                        <?php echo BorangPenilaianLatihanLama::checkBorangStatusp($lat->vcl_kod_latihan, $lat->vcl_id_staf); ?>
                                    </td>
                                </tr>
                            <?php
                                        }
                                    } else { ?>
                            <tr>
                                <td colspan="3" class="align-center text-center"><i>Belum Hadir Latihan</i></td>
                            </tr>
                        <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="x_panel">
                <div class="x_title">
                    <h5>Elektif</h5>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div>
                        <?php

                        $bil = 1;
                        ?><?php
                                    if ($elektif) { ?>
                        <table class="table table-striped jambo_table">
                            <thead>
                                <tr>
                                    <th class="text-center">Bil</th>
                                    <th class="text-center">Nama Kursus</th>
                                    <th class="text-center">Tarikh Kursus</th>
                                    <th class="text-center">Jumlah Mata</th>
                                    <!--                                                <th class="text-center">Jenis</th>-->
                                    <th class="text-center">Penilaian Kursus</th>
                                </tr>
                            </thead>
                            <?php
                                        foreach ($elektif as $lat) {
                                            //echo $lat->latihan->vcsl_nama_latihan . '<br>';
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $bil++ ?></td>
                                    <td class="text-left"><?php echo strtoupper($lat->latihan->vcsl_nama_latihan);
                                                            //$lat->sasaran9->sasaran4->latihan->vcsl_nama_latihan; 
                                                            //echo $lat->vcsl_nama_latihan; 
                                                            ?></td>
                                    <td class="text-center"><?php echo $lat->vcl_tkh_mula; ?></td>
                                    <td class="text-center"><?php echo $lat->vcl_jum_mata; ?></td>
                                    <!--                                                <td class="text-center"><?php //echo KursusLatihan::identifyJenis($lat->kursusLatihanID) 
                                                                                                                ?></td>-->
                                    <td class="text-center">
                                        <?php echo BorangPenilaianLatihanLama::checkBorangStatusp($lat->vcl_kod_latihan, $lat->vcl_id_staf); ?>
                                    </td>
                                </tr>
                            <?php
                                        }
                                    } else { ?>
                            <tr>
                                <td colspan="3" class="align-center text-center"><i>Belum Hadir Latihan</i></td>
                            </tr>
                        <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="x_panel">
                <div class="x_title">
                    <h5>Umum</h5>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div>
                        <?php

                        $bil = 1;
                        ?><?php
                                    if ($umum) { ?>
                        <table class="table table-striped jambo_table">
                            <thead>
                                <tr>
                                    <th class="text-center">Bil</th>
                                    <th class="text-center">Nama Kursus</th>
                                    <th class="text-center">Tarikh Kursus</th>
                                    <th class="text-center">Jumlah Mata</th>
                                    <!--                                                <th class="text-center">Jenis</th> -->
                                </tr>
                            </thead>
                            <?php
                                        foreach ($umum as $lat) {
                                            //echo $lat->latihan->vcsl_nama_latihan . '<br>';
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $bil++ ?></td>
                                    <td class="text-left"><?php echo strtoupper($lat->latihan->vcsl_nama_latihan);
                                                            //$lat->sasaran9->sasaran4->latihan->vcsl_nama_latihan; 
                                                            //echo $lat->vcsl_nama_latihan; 
                                                            ?></td>
                                    <td class="text-center"><?php echo $lat->vcl_tkh_mula; ?></td>
                                    <td class="text-center"><?php echo $lat->vcl_jum_mata; ?></td>
                                </tr>
                            <?php
                                        }
                                    } else { ?>
                            <tr>
                                <td colspan="3" class="align-center text-center"><i>Belum Hadir Latihan</i></td>
                            </tr>
                        <?php } ?>
                        </table>
                    </div> <!-- ubah sini -->
                </div> <!-- x_content -->
            </div>

        <?php } ?>
    </div>
</div>