
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
            'text' => $month,
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
                'text' => 'Non-compliance Status'
            ]
        ],
        'series' => $data,
        
        
    ]
]);
?>