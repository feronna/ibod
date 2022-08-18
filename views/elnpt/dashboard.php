<?php

use dosamigos\chartjs\ChartJs;
/* @var $this yii\web\View */

foreach ($totalPerYear as $ind => $tp) {
    // $totalPerYear[$ind]['label'] = $tp['tahun'];
    $totalPerYear[$ind]['backgroundColor'] = 'rgba(255,99,132,0.2)';
    $totalPerYear[$ind]['borderColor'] = 'rgba(255,99,132,1)';
    // $totalPerYear[$ind]['data'] = [$tp['cnt']];
}

?>

<?= $this->render('_menuAdmin'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Dashboard</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?= ChartJs::widget([
                    'type' => 'bar',
                    'options' => [
                        'responsive' => true,
                        'height' => 80,
                    ],
                    'clientOptions' => [
                        'responsive' => true,
                        'scales' => [
                            'yAxes' => [[
                                'ticks' => [
                                    'min' => 0,
                                    // 'max' => 100,
                                ],
                            ]],
                        ],
                    ],
                    'data' => [
                        'labels' => \yii\helpers\ArrayHelper::getColumn($totalPerYear, 'tahun'),
                        // 'datasets' => $totalPerYear,
                        'datasets' => [
                            [
                                'axis' => 'y',
                                'label' => 'Jumlah Borang LNPT Per Tahun',
                                'data' => \yii\helpers\ArrayHelper::getColumn($totalPerYear, 'cnt'),
                                'fill' => false,
                                'backgroundColor' => [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(255, 159, 64, 0.2)',
                                    'rgba(255, 205, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(201, 203, 207, 0.2)'
                                ],
                                'borderColor' => [
                                    'rgb(255, 99, 132)',
                                    'rgb(255, 159, 64)',
                                    'rgb(255, 205, 86)',
                                    'rgb(75, 192, 192)',
                                    'rgb(54, 162, 235)',
                                    'rgb(153, 102, 255)',
                                    'rgb(201, 203, 207)'
                                ],
                                'borderWidth' => 1
                            ]
                        ],
                        // 'labels' => ['asd',' asda'],
                        // 'labels' => ['asd',' asda'],
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
</div>