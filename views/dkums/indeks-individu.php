<?php

use app\models\dkums\Questions;
use dosamigos\chartjs\ChartJs;
?>

<?= Yii::$app->controller->renderPartial('_menu'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-bar-chart"></i>&nbsp;<strong><?= $this->title ?></strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <table class="table table-bordered table-striped table-condensed">
                    <tr style="font-weight: bold">
                        <td class="text-center">
                            <p style="font-size:40px">DKUMS</p>
                            <font style="font-size:80px"><?= $main->dkums ?> %</font><br>
                            <font style="font-size:20px"><i style="color:green"><?= $main->tahapDkums; ?></i></font>
                        </td>
                    </tr>
                </table>

                <?= ChartJs::widget([
                    'type' => 'radar',
                    'options' => [
                        'responsive' => true,
                        'height' => 60,
                    ],
                    'clientOptions' => [
                        'responsive' => true,
                        'scales' => [
                            'yAxes' => [[
                                'ticks' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ]],
                        ],
                    ],
                    'data' => [
                        'labels' => ['Penilaian Hidup', 'Emosi Positif', 'Kepuasan Kerja', 'Keterlibatan Kerja'],
                        'datasets' => [
                            [
                                'label' => "Dimensi",
                                // 'backgroundColor' => "#518EC1",
                                'borderColor' => "rgba(255,99,132,1)",
                                'pointBackgroundColor' => "rgba(255,99,132,1)",
                                'pointBorderColor' => "#fff",
                                'pointHoverBackgroundColor' => "#fff",
                                // 'pointHoverBorderColor' => "rgba(255,99,132,1)",
                                'data' => [$main->penilaianHidup, $main->emosiPositif, $main->kepuasanKerja, $main->keterlibatanKerja],
                            ],
                        ],
                    ],

                ]);
                ?>

                <!-- Penilaian Hidup -->
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                        <tr class="headings">
                            <th class="text-center" style="width: 30%;">Dimensi</th>
                            <th class="text-center" style="width: 10%;">Kedudukan Item</th>
                            <th class="text-center">Kenyataan Item</th>
                            <th class="text-center" style="width: 10%;">Skala</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="6" style="font-size: 30px;" class="text-center">Penilaian Hidup<br><?= $main->penilaianHidup; ?>%</td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($h1 = 'a1'); ?></td>
                            <td><?= Questions::displayQuestion($h1) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $hidup->$h1 ?></span></td>
                        </tr>
                    </tbody>
                </table>
                <!-- Penilaian Hidup -->





                <!-- AFEK -->
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                        <tr class="headings">
                            <th class="text-center" style="width: 30%;">Sub-dimensi</th>
                            <th class="text-center" style="width: 10%;">Kedudukan Item</th>
                            <th class="text-center">Kenyataan Item</th>
                            <th class="text-center" style="width: 10%;">Skala</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="6" style="font-size: 30px;" class="text-center">Afek Positif<br><?= $main->afekPositif; ?>%</td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($a1 = 'b1'); ?></td>
                            <td><?= Questions::displayQuestion($a1) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $affect->$a1 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($a2 = 'b5'); ?></td>
                            <td><?= Questions::displayQuestion($a2) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $affect->$a2 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($a3 = 'b7'); ?></td>
                            <td><?= Questions::displayQuestion($a3) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $affect->$a3 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($a4 = 'b8'); ?></td>
                            <td><?= Questions::displayQuestion($a4) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $affect->$a4 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($a5 = 'b10'); ?></td>
                            <td><?= Questions::displayQuestion($a5) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $affect->$a5 ?></span></td>
                        </tr>
                        <tr>
                            <td rowspan="6" style="font-size: 30px;" class="text-center">Afek Negatif<br><?= $main->afekNegatif; ?>%</td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($a6 = 'b2'); ?></td>
                            <td><?= Questions::displayQuestion($a6) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $affect->$a6 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($a7 = 'b3'); ?></td>
                            <td><?= Questions::displayQuestion($a7) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $affect->$a7 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($a8 = 'b4'); ?></td>
                            <td><?= Questions::displayQuestion($a8) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $affect->$a8 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($a9 = 'b6'); ?></td>
                            <td><?= Questions::displayQuestion($a9) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $affect->$a9 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($a10 = 'b9'); ?></td>
                            <td><?= Questions::displayQuestion($a10) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $affect->$a10 ?></span></td>
                        </tr>
                    </tbody>
                </table>
                <!-- AFEK -->

                <!-- KETERLIBATAN KERJA -->
                <div class="pull-left" style="font-size: 35px;">Dimensi Keterlibatan Kerja : <strong><?= $main->keterlibatanKerja ?>%</strong></div>
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                        <tr class="headings">
                            <th class="text-center" style="width: 30%;">Sub-dimensi</th>
                            <th class="text-center" style="width: 10%;">Kedudukan Item</th>
                            <th class="text-center">Kenyataan Item</th>
                            <th class="text-center" style="width: 10%;">Skala</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="4" style="font-size: 30px;" class="text-center">Semangat<br><?= $main->semangat; ?>%</td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n1 = 'd1'); ?></td>
                            <td><?= Questions::displayQuestion($n1) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $keterlibatan_kerja->$n1 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n2 = 'd2'); ?></td>
                            <td><?= Questions::displayQuestion($n2) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $keterlibatan_kerja->$n2 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n3 = 'd5'); ?></td>
                            <td><?= Questions::displayQuestion($n3) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $keterlibatan_kerja->$n3 ?></span></td>
                        </tr>
                        <tr>
                            <td rowspan="4" style="font-size: 30px;" class="text-center">Dedikasi<br><?= $main->dedikasi; ?>%</td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n4 = 'd3'); ?></td>
                            <td><?= Questions::displayQuestion($n4) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $keterlibatan_kerja->$n4 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n5 = 'd4'); ?></td>
                            <td><?= Questions::displayQuestion($n5) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $keterlibatan_kerja->$n5 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n6 = 'd7'); ?></td>
                            <td><?= Questions::displayQuestion($n6) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $keterlibatan_kerja->$n6 ?></span></td>
                        </tr>
                        <tr>
                            <td rowspan="4" style="font-size: 30px;" class="text-center">Kesungguhan<br><?= $main->kesungguhan; ?>%</td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n7 = 'd6'); ?></td>
                            <td><?= Questions::displayQuestion($n7) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $keterlibatan_kerja->$n7 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n8 = 'd8'); ?></td>
                            <td><?= Questions::displayQuestion($n8) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $keterlibatan_kerja->$n8 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n9 = 'd9'); ?></td>
                            <td><?= Questions::displayQuestion($n9) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $keterlibatan_kerja->$n9 ?></span></td>
                        </tr>
                    </tbody>
                </table>
                <!-- KETERLIBATAN KERJA -->

                <!-- KEPUASAN KERJA -->
                <div class="pull-left" style="font-size: 35px;">Dimensi Kepuasan Kerja : <strong><?= $main->kepuasanKerja ?>%</strong></div>
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                        <tr class="headings">
                            <th class="text-center" style="width: 30%;">Sub-dimensi</th>
                            <th class="text-center" style="width: 10%;">Kedudukan Item</th>
                            <th class="text-center">Kenyataan Item</th>
                            <th class="text-center" style="width: 10%;">Skala</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="4" style="font-size: 30px;" class="text-center">Gaji<br><?= $main->gaji; ?>%</td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n1 = 'c1'); ?></td>
                            <td><?= Questions::displayQuestion($n1) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $kepuasan_kerja->$n1 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n2 = 'c15'); ?></td>
                            <td><?= Questions::displayQuestion($n2) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $kepuasan_kerja->$n2 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n3 = 'c21'); ?></td>
                            <td><?= Questions::displayQuestion($n3) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $kepuasan_kerja->$n3 ?></span></td>
                        </tr>
                        <tr>
                            <td rowspan="4" style="font-size: 30px;" class="text-center">Kenaikan Pangkat<br><?= $main->pangkat; ?>%</td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n4 = 'c2'); ?></td>
                            <td><?= Questions::displayQuestion($n4) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $kepuasan_kerja->$n4 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n5 = 'c9'); ?></td>
                            <td><?= Questions::displayQuestion($n5) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $kepuasan_kerja->$n5 ?></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n6 = 'c24'); ?></td>
                            <td><?= Questions::displayQuestion($n6) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $kepuasan_kerja->$n6 ?></span></td>
                        </tr>
                        <tr>
                            <td rowspan="4" style="font-size: 30px;" class="text-center">Penyeliaan<br><?= $main->penyeliaan; ?>%</td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n7 = 'c3'); ?></td>
                            <td><?= Questions::displayQuestion($n7) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $kepuasan_kerja->$n7 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n8 = 'c16'); ?></td>
                            <td><?= Questions::displayQuestion($n8) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $kepuasan_kerja->$n8 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n9 = 'c23'); ?></td>
                            <td><?= Questions::displayQuestion($n9) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $kepuasan_kerja->$n9 ?></span></td>
                        </tr>
                        <!----------------------------------------------------------------------------------------------------------------->
                        <tr>
                            <td rowspan="4" style="font-size: 30px;" class="text-center">Faedah Sampingan<br><?= $main->faedah; ?>%</td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n10 = 'c4'); ?></td>
                            <td><?= Questions::displayQuestion($n10) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $kepuasan_kerja->$n10 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n11 = 'c10'); ?></td>
                            <td><?= Questions::displayQuestion($n11) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $kepuasan_kerja->$n11 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n12 = 'c22'); ?></td>
                            <td><?= Questions::displayQuestion($n12) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $kepuasan_kerja->$n12 ?></span></td>
                        </tr>
                        <!----------------------------------------------------------------------------------------------------------------->
                        <tr>
                            <td rowspan="4" style="font-size: 30px;" class="text-center">Ganjaran Luar Jangka<br><?= $main->ganjaran; ?>%</td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n13 = 'c5'); ?></td>
                            <td><?= Questions::displayQuestion($n13) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $kepuasan_kerja->$n13 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n14 = 'c11'); ?></td>
                            <td><?= Questions::displayQuestion($n14) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $kepuasan_kerja->$n14 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n15 = 'c17'); ?></td>
                            <td><?= Questions::displayQuestion($n15) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $kepuasan_kerja->$n15 ?></span></td>
                        </tr>
                        <!----------------------------------------------------------------------------------------------------------------->
                        <tr>
                            <td rowspan="4" style="font-size: 30px;" class="text-center">Prosedur Operasi<br><?= $main->prosedur; ?>%</td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n16 = 'c6'); ?></td>
                            <td><?= Questions::displayQuestion($n16) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $kepuasan_kerja->$n16 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n17 = 'c12'); ?></td>
                            <td><?= Questions::displayQuestion($n17) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $kepuasan_kerja->$n17 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n18 = 'c18'); ?></td>
                            <td><?= Questions::displayQuestion($n18) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $kepuasan_kerja->$n18 ?></span></td>
                        </tr>
                        <!----------------------------------------------------------------------------------------------------------------->
                        <tr>
                            <td rowspan="4" style="font-size: 30px;" class="text-center">Rakan Sekerja<br><?= $main->rakan; ?>%</td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n19 = 'c13'); ?></td>
                            <td><?= Questions::displayQuestion($n19) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $kepuasan_kerja->$n19 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n20 = 'c19'); ?></td>
                            <td><?= Questions::displayQuestion($n20) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $kepuasan_kerja->$n20 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n21 = 'c25'); ?></td>
                            <td><?= Questions::displayQuestion($n21) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $kepuasan_kerja->$n21 ?></span></td>
                        </tr>
                        <!----------------------------------------------------------------------------------------------------------------->
                        <tr>
                            <td rowspan="4" style="font-size: 30px;" class="text-center">Sifat Kerja<br><?= $main->sifat; ?>%</td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n19 = 'c7'); ?></td>
                            <td><?= Questions::displayQuestion($n19) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $kepuasan_kerja->$n19 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n20 = 'c20'); ?></td>
                            <td><?= Questions::displayQuestion($n20) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $kepuasan_kerja->$n20 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n21 = 'c26'); ?></td>
                            <td><?= Questions::displayQuestion($n21) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $kepuasan_kerja->$n21 ?></span></td>
                        </tr>
                        <!----------------------------------------------------------------------------------------------------------------->
                        <tr>
                            <td rowspan="4" style="font-size: 30px;" class="text-center">Komunikasi<br><?= $main->komunikasi; ?>%</td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n22 = 'c8'); ?></td>
                            <td><?= Questions::displayQuestion($n22) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $kepuasan_kerja->$n22 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n23 = 'c14'); ?></td>
                            <td><?= Questions::displayQuestion($n23) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $kepuasan_kerja->$n23 ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?= strtoupper($n24 = 'c27'); ?></td>
                            <td><?= Questions::displayQuestion($n24) ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $kepuasan_kerja->$n24 ?></span></td>
                        </tr>
                        <!----------------------------------------------------------------------------------------------------------------->
                    </tbody>
                </table>
                <!-- KEPUASAN KERJA -->



            </div>
        </div>
    </div>
</div>