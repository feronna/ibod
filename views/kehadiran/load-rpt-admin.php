<?php

use dosamigos\highcharts\HighCharts;
?>




<?=

HighCharts::widget([
    'clientOptions' => [
        'chart' => [
            'type' => 'bar'
        ],
        'title' => [
            'text' => $title
        ],
        'xAxis' => [
            'categories' => [
                'Late In',
                'Early Out',
                'Incomplete',
                'Absent',
                'External',
            ]
        ],
        'yAxis' => [
            'title' => [
                'text' => 'Ketidakpatuhan/Kesalahan'
            ]
        ],
        'series' => $data,
           
        
    ]
]);
?>


