
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
            'text' => 'Jumlah Kad Warna Tahun 2019'
        ],
        'subtitle' => [
//            'text' => 'Source: WorldClimate.com'
        ],
        'xAxis' => [
            'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        ],
        'yAxis' => [
            'title' => [
                'text' => 'Bilangan Warna Kad',
            ],
        ],
//        'tooltip' => [
//            'headerFormat' => '<span style="font-size:10px">{point.key}</span><table>',
//            'pointFormat' => '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
//            'footerFormat' => '</table>',
//            'shared' => true,
//            'useHTML' => true
//        ],
        'plotOptions' => [
            'column' => [
                'pointPadding' => 0.2,
                'borderWidth' => 0
            ]
        ],
        'series' => [
            [
                'name' => 'Kuning',
                'data' => $yellow,
                'color' => 'yellow'
            ], [
                'name' => 'Hijau',
                'data' => $green,
                'color' => 'green'
            ], [
                'name' => 'Merah',
                'data' => $red,
                'color' => 'red'
            ]
        ]
    ],
]);
?>