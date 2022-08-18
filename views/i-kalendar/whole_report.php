<?php

use dosamigos\chartjs\ChartJs;
use yii\helpers\ArrayHelper;

$i = 1;
?>

<?= $this->render('_menuAdmin'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Statistik Tahunan Aktiviti Jabatan Pendaftar</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th class="text-center">BAHAGIAN</th>
                            <th class="text-center" colspan="2">BSM</th>
                            <th class="text-center" colspan="2">BPA</th>
                            <th class="text-center" colspan="2">BPG</th>
                            <th class="text-center" colspan="2">BPQ</th>
                            <th class="text-center" colspan="2">BKES</th>
                            <th class="text-center" colspan="2">JUMLAH</th>
                        </tr>
                        <tr>
                            <th class="text-center">BULAN</th>
                            <th class="text-center">R</th>
                            <th class="text-center">T</th>
                            <th class="text-center">R</th>
                            <th class="text-center">T</th>
                            <th class="text-center">R</th>
                            <th class="text-center">T</th>
                            <th class="text-center">R</th>
                            <th class="text-center">T</th>
                            <th class="text-center">R</th>
                            <th class="text-center">T</th>
                            <th class="text-center">R</th>
                            <th class="text-center">T</th>
                        </tr>
                        <?php
                        while ($i <= 12) {
                        ?>
                            <tr>
                                <th class="text-center" style="vertical-align: middle;"> <?= date('F', mktime(0, 0, 0, $i, 10)); ?> </th>
                                <td class="text-center"> <?= $laporan[0][$i][0]['R'] ?? '0'; ?> </td>
                                <td class="text-center"> <?= $laporan[0][$i][0]['T'] ?? '0'; ?> </td>
                                <td class="text-center"> <?= $laporan[2][$i][0]['R'] ?? '0'; ?> </td>
                                <td class="text-center"> <?= $laporan[2][$i][0]['T'] ?? '0'; ?> </td>
                                <td class="text-center"> <?= $laporan[1][$i][0]['R'] ?? '0'; ?> </td>
                                <td class="text-center"> <?= $laporan[1][$i][0]['T'] ?? '0'; ?> </td>
                                <td class="text-center"> <?= $laporan[4][$i][0]['R'] ?? '0'; ?> </td>
                                <td class="text-center"> <?= $laporan[4][$i][0]['T'] ?? '0'; ?> </td>
                                <td class="text-center"> <?= $laporan[3][$i][0]['R'] ?? '0'; ?> </td>
                                <td class="text-center"> <?= $laporan[3][$i][0]['T'] ?? '0'; ?> </td>
                                <td class="text-center"> <?= ($laporan[0][$i][0]['R'] ?? '0') +  ($laporan[2][$i][0]['R'] ?? '0') +  ($laporan[1][$i][0]['R'] ?? '0') +  ($laporan[4][$i][0]['R'] ?? '0') +  ($laporan[3][$i][0]['R'] ?? '0'); ?> </td>
                                <td class="text-center"> <?= ($laporan[0][$i][0]['T'] ?? '0') +  ($laporan[2][$i][0]['T'] ?? '0') +  ($laporan[1][$i][0]['T'] ?? '0') +  ($laporan[4][$i][0]['T'] ?? '0') + ($laporan[3][$i][0]['T'] ?? '0'); ?> </td>
                            </tr>
                        <?php
                            $i++;
                        }
                        ?>
                        <tr>
                            <th class="text-center"> JUMLAH</th>
                            <th class="text-center"> <?= $a1 =  array_sum(ArrayHelper::getColumn(array_values($laporan[0]), function ($element) {
                                                            return $element[0]['R'];
                                                        })); ?> </th>
                            <th class="text-center"> <?= $b1 =  array_sum(ArrayHelper::getColumn(array_values($laporan[0]), function ($element) {
                                                            return $element[0]['T'];
                                                        })); ?> </th>
                            <th class="text-center"> <?= $a2 =   array_sum(ArrayHelper::getColumn(array_values($laporan[2]), function ($element) {
                                                            return $element[0]['R'];
                                                        })); ?> </th>
                            <th class="text-center"> <?= $b2 = array_sum(ArrayHelper::getColumn(array_values($laporan[2]), function ($element) {
                                                            return $element[0]['T'];
                                                        })); ?> </th>
                            <th class="text-center"> <?= $a3 =   array_sum(ArrayHelper::getColumn(array_values($laporan[1]), function ($element) {
                                                            return $element[0]['R'];
                                                        })); ?> </th>
                            <th class="text-center"> <?= $b3 =  array_sum(ArrayHelper::getColumn(array_values($laporan[1]), function ($element) {
                                                            return $element[0]['T'];
                                                        })); ?> </th>
                            <th class="text-center"> <?= $a4 =  array_sum(ArrayHelper::getColumn(array_values($laporan[4]), function ($element) {
                                                            return $element[0]['R'];
                                                        })); ?> </th>
                            <th class="text-center"> <?= $b4 =  array_sum(ArrayHelper::getColumn(array_values($laporan[4]), function ($element) {
                                                            return $element[0]['T'];
                                                        })); ?> </th>
                            <th class="text-center"> <?= $a5 =   array_sum(ArrayHelper::getColumn(array_values($laporan[3]), function ($element) {
                                                            return $element[0]['R'];
                                                        })); ?> </th>
                            <th class="text-center"> <?= $b5 =  array_sum(ArrayHelper::getColumn(array_values($laporan[3]), function ($element) {
                                                            return $element[0]['T'];
                                                        })); ?> </th>
                            <th class="text-center"> <?= $a1 + $a2 + $a3 + $a4 + $a5; ?> </th>
                            <th class="text-center"> <?= $b1 + $b2 + $b3 + $b4 + $b5; ?> </th>
                        </tr>
                        <tr>
                            <th class="text-center">JUMLAH KESELURUHAN</th>
                            <th class="text-center" colspan="2"><?= $a1 + $b1; ?></th>
                            <th class="text-center" colspan="2"><?= $a2 + $b2; ?></th>
                            <th class="text-center" colspan="2"><?= $a3 + $b3; ?></th>
                            <th class="text-center" colspan="2"><?= $a4 + $b4; ?></th>
                            <th class="text-center" colspan="2"><?= $a5 + $b5; ?></th>
                            <th class="text-center" colspan="2"><?= $totalSum = ($a1 + $a2 + $a3 + $a4 + $a5) + ($b1 + $b2 + $b3 + $b4 + $b5); ?></th>
                        </tr>
                    </table>
                </div>

                <div style="clear: both;"><br>

                    <dl class="dl-horizontal">
                        <dt>R</dt>
                        <dd>AKTIVITI DIRANCANG</dd>
                        <dt>T</dt>
                        <dd>TAMBAHAN AKTIVITI BARU</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="table-responsive">
                    <div class="col-md-12"><?php
                                            echo ChartJs::widget([
                                                'type' => 'pie',
                                                'id' => 'structurePie',
                                                'options' => [
                                                    'height' => 500,
                                                    'width' => 500,
                                                ],
                                                'data' => [
                                                    'radius' =>  "90%",
                                                    'labels' => ['BSM', 'BPA', 'BPG', 'BPQ', 'BKES'], // Your labels
                                                    'datasets' => [
                                                        [
                                                            'data' => [round((($a1 + $b1) / $totalSum) * 100), round((($a2 + $b2) / $totalSum) * 100), round((($a3 + $b3) / $totalSum) * 100), round((($a4 + $b4) / $totalSum) * 100), round((($a5 + $b5) / $totalSum) * 100)], // Your dataset
                                                            'label' => '',
                                                            'backgroundColor' => [
                                                                '#ADC3FF',
                                                                '#FF9A9A',
                                                                'rgba(190, 124, 145, 0.8)',
                                                                '#90EE90',
                                                                '#ADD8E6'
                                                            ],
                                                            'borderColor' =>  [
                                                                '#fff',
                                                                '#fff',
                                                                '#fff',
                                                                '#fff',
                                                                '#fff'
                                                            ],
                                                            'borderWidth' => 1,
                                                            'hoverBorderColor' => ["#999", "#999", "#999"],
                                                        ]
                                                    ]
                                                ],
                                                'clientOptions' => [
                                                    // 'legend' => [
                                                    //     'display' => false,
                                                    //     'position' => 'bottom',
                                                    //     'labels' => [
                                                    //         'fontSize' => 14,
                                                    //         'fontColor' => "#425062",
                                                    //     ]
                                                    // ],
                                                    // 'tooltips' => [
                                                    //     'enabled' => true,
                                                    //     'intersect' => true
                                                    // ],
                                                    // 'hover' => [
                                                    //     'mode' => false
                                                    // ],
                                                    'maintainAspectRatio' => false,

                                                ],
                                            ]);
                                            ?></div>
                </div>
            </div>
        </div>
    </div>
</div>