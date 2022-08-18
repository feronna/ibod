<?php

use dosamigos\chartjs\ChartJs;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use dosamigos\highcharts\HighCharts;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\Html;

$result = ArrayHelper::getColumn($bar, function ($element) {
    return (int)$element['data'];
});

foreach ($pie as $ind => $p) {
    $pie[$ind]['y'] = (int)$pie[$ind]['y'];
}
foreach ($pie2 as $ind => $p) {
    $pie2[$ind]['y'] = (int)$pie2[$ind]['y'];
}
?>

<?= $this->render('_menu'); ?>

<?= $this->render('_searchBorang', ['model' => $searchModel, 'title' => $titleEmou]) ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carta</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content collapse">
                <div class="row">
                    <div class="table-responsive">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <?=
                            HighCharts::widget([
                                'clientOptions' => [
                                    'chart' => [
                                        'type' => 'column'
                                    ],
                                    'title' => [
                                        'text' => 'Carta Palang Memorandum Mengikut JFPIU'
                                    ],
                                    'xAxis' => [
                                        'categories' =>  ArrayHelper::getColumn($bar, 'name')
                                    ],
                                    'yAxis' => [
                                        'title' => [
                                            'text' => 'Jumlah Keseluruhan'
                                        ]
                                    ],
                                    'series' =>  [['type' => 'column', 'data' => $result,]],
                                    'legend' => false,
                                    'plotOptions' => [
                                        'series' => [
                                            'colorByPoint' => true,
                                            'dataLabels' => [
                                                'enabled' => true
                                            ]
                                        ]
                                    ],
                                    'tooltip' => [
                                        'enabled' => false
                                    ]
                                ]
                            ]);
                            ?>

                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <?=
                            HighCharts::widget([
                                'clientOptions' => [
                                    'chart' => [
                                        'type' => 'pie'
                                    ],
                                    'title' => [
                                        'text' => 'Carta Pai Memorandum Mengikut Negara'
                                    ],
                                    'series' =>  [
                                        [
                                            'data' => $pie,
                                        ]
                                    ],
                                    'legend' => false,
                                    'plotOptions' => [
                                        'series' => [
                                            'dataLabels' => [
                                                'enabled' => true,
                                                'format' => '{point.name}: {point.y}'
                                            ]
                                        ]
                                    ],
                                    'tooltip' => [
                                        'enabled' => false
                                    ]
                                ]
                            ]);
                            ?>

                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <?=
                            HighCharts::widget([
                                'clientOptions' => [
                                    'chart' => [
                                        'type' => 'pie'
                                    ],
                                    'title' => [
                                        'text' => 'Carta Pai Memorandum Mengikut Jenis'
                                    ],
                                    'series' =>  [
                                        [
                                            'data' => $pie2,
                                        ]
                                    ],
                                    'legend' => false,
                                    'plotOptions' => [
                                        'series' => [
                                            'dataLabels' => [
                                                'enabled' => true,
                                                'format' => '{point.name}: {point.y}'
                                            ]
                                        ]
                                    ],
                                    'tooltip' => [
                                        'enabled' => false
                                    ]
                                ]
                            ]);
                            ?>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Laporan</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="table-responsive">
                        <?=
                        GridView::widget([
                            'emptyText' => 'Tiada Rekod',
                            'summary' => '',
                            'pager' => [
                                'class' => \kop\y2sp\ScrollPager::className(),
                                'container' => '.grid-view tbody',
                                'triggerOffset' => 10,
                                'item' => 'tr',
                                'paginationSelector' => '.grid-view .pagination',
                                'triggerTemplate' => '<tr class="ias-trigger"><td colspan="100%" style="text-align: center"><a style="cursor: pointer">{text}</a></td></tr>',
                            ],
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'header' => 'BIL',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'label' => 'JAFPIB',
                                    'headerOptions' => ['class' => 'text-center col-md-2'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return $model->department->fullname;
                                    },
                                    //'attribute' => 'tahun',
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'AGENSI LUAR',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return $model->external_parties;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'SENARAI BIDANG',
                                    'headerOptions' => ['class' => 'text-center'],
                                    // 'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        $str = '<ol>';
                                        foreach ($model->emouField as $mod) {
                                            $str .= '<li>' . $mod->field_desc . '</li>';
                                        }
                                        $str .= '</ol>';

                                        return $str;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'SENARAI KPI',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    // 'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        $str = '<ol>';
                                        foreach ($model->emouKpi as $mod) {
                                            $str .= '<li>' . $mod->kpi_desc . '</li>';
                                        }
                                        $str .= '</ol>';

                                        return sizeof($model->emouKpi) == 0 ? 'Tiada Maklumat KPI' : $str;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'SENARAI AKTIVITI',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    // 'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        $str = '<ol>';
                                        foreach ($model->emouActivity as $mod) {
                                            $str .= '<li>' . $mod->activity_desc . '</li>';
                                        }
                                        $str .= '</ol>';

                                        return sizeof($model->emouActivity) == 0 ? 'Tiada Maklumat Aktiviti' : $str;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'TARIKH LUPUT',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return $model->expiration_date;
                                        // return Yii::$app->formatter->asDate($model->last_update, 'dd/MM/yyyy');
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'STATUS',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return $model->emouStatus->status_desc;
                                    },
                                    'format' => 'html',
                                    'attribute' => 'id_status',
                                ],
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>