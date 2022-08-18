
<?php

use dosamigos\highcharts\HighCharts;
?>

<?=

HighCharts::widget([
    'clientOptions' => [
        'chart' => [
            'type' => 'column'
        ],
        'title' => [
            'text' => '',
        ],
        'xAxis' => [
            'categories'=>$categories,
        ],
        'yAxis' => [
            'title' => [
                'text' => 'Total'
            ]
        ],
        'series' => $data,
        
        
    ]
]);
?>