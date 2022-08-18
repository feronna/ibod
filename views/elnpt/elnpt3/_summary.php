<?php
$this->registerJs('');

use dosamigos\chartjs\ChartJs;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

$labels = ['PENGAJARAN & PENYELIAAN', 'PENYELIDIKAN & PENERBITAN', 'PERKHIDMATAN', 'KLINIKAL'];
$cats = [
    ($summary->k1_k2 * 100 / $fapi['k1_k2']),
    ($summary->k3_k4 * 100 / $fapi['k3_k4']),
    ($summary->k5 * 100 / $fapi['k5']),
    (($fapi['k6'] != 0) ?  ($summary->k6 * 100 / $fapi['k6']) : 0)
];

if (strpos($lpp->gredGuru->gred, 'DU') === false) {
    array_splice($labels, 3, 1);
    array_splice($cats, 3, 1);
}
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">
            <h4>Ringkasan Markah</h4>
        </li>
    </ol>
</nav>

<div>
    <?= ChartJs::widget([
        'type' => 'radar',
        'id' => 'structureDoughnut',
        'options' => [
            'height' => 300,
            'width' => 500,
        ],
        'data' => [
            //'radius' =>  "90%",
            'labels' => $labels,
            'datasets' => [
                [
                    'data' => $cats,
                    'label' => 't',
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
                    // 'suggestedMax' => max(array_values(ArrayHelper::getColumn($pemberat, 'pemberat'))),
                    'suggestedMax' => max([$fapi['k1_k2'], $fapi['k3_k4'], $fapi['k5'], $fapi['k6']]),
                    'stepSize' => 10,
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

<div class="clearfix"></div>
<hr />

<div>
    <?=
    \kartik\detail\DetailView::widget([
        'model' => $summary,
        'labelColOptions' => ['style' => 'width: 30%'],
        'attributes' => [
            [
                'label' => 'MARKAH PENGAJARAN & PENYELIAAN',
                'value' => Yii::$app->formatter->asPercent($summary->k1_k2 / 100),
            ],
            [
                'label' => 'MARKAH PENYELIDIKAN & PENERBITAN',
                'value' => Yii::$app->formatter->asPercent($summary->k3_k4 / 100),
            ],
            [
                'label' => 'MARKAH PERKHIDMATAN',
                'value' => Yii::$app->formatter->asPercent($summary->k5 / 100),
            ],
            [
                'label' => 'MARKAH KLINIKAL',
                'value' => Yii::$app->formatter->asPercent($summary->k6 / 100),
                'visible' => (strpos($lpp->gredGuru->gred, 'DU') !== false),
            ],
            [
                'label' => 'JUMLAH MARKAH KOMPONEN PROFESIONAL',
                'value' =>  Yii::$app->formatter->asPercent(($summary->k1_k2 + $summary->k3_k4 + $summary->k5 + $summary->k6) / 100) . ' daripada 100%',
                'format'    => 'html',
            ],
            [
                'label' => 'JUMLAH MARKAH KOMPONEN PROFESIONAL (90%)',
                'value' => (($summary->k1_k2 + $summary->k3_k4 + $summary->k5 + $summary->k6) / 100 * 90) . '% daripada 90%',
                'format'    => 'html',
            ],
            [
                'label' => 'JUMLAH MARKAH KOMPONEN SAHSIAH (10%)',
                'value' =>  Yii::$app->formatter->asPercent(0) . ' daripada 10%',
                'format'    => 'html',
            ],
            [
                'label' => 'MARKAH KESELURUHAN',
                'value' => ((($summary->k1_k2 + $summary->k3_k4 + $summary->k5 + $summary->k6) / 100 * 90) + 0) . '% daripada 100%',
                'format'    => 'html',
            ],
            [
                'label' => 'STATUS MARKAH KOMPONEN PROFESIONAL',
                'value' =>  '<h2>' . $kategori . '</h2>',
                'format'    => 'html',
            ],
        ]
    ])
    ?>
</div>