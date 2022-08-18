<?php

use dosamigos\highcharts\HighCharts;
?>

<?=

HighCharts::widget([
    'clientOptions' => [
        'chart' => [
            'type' => 'column'
        ],
        'exporting' => ['enabled'=>false],
        'credits' => ['enabled'=>false],
        'title' => [
            'text' => $tahun,
        ],
        'xAxis' => [
            'categories' => [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec',
            ]
        ],
        'yAxis' => [
            'title' => [
                'text' => 'Total day'
            ]
        ],
        'series' => $data,
    ]
]);
?>


