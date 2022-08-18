<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\export\ExportMenu;
use app\models\myidp\TblYears;
use app\models\myidp\VIdpKumpulan;
use app\models\hronline\Department;
use app\models\myidp\RptStatistikIdp;
use app\models\myidp\StatistikKursusDalamanByKehadiran;

echo $this->render('/idp/_topmenu');

error_reporting(0);

$gridColumnsK = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'header' => 'BIL',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'headerOptions' => [
            'style' => 'display: none;',
        ],
    ],
    [
        'label' => 'BULAN',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'format' => 'raw',
        'value' => function ($model) {
            return strtoupper($model->month);
        },
        'contentOptions' => ['style' => 'width:150px; white-space: normal;'],
        'headerOptions' => [
            'style' => 'display: none;',
        ],
        'pageSummary' => '<b>JUMLAH KESELURUHAN</b>',
    ],

    [
        'label' => 'JUMLAH KURSUS',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'format' => 'raw',
        'value' => function ($model) use ($year) {
            return StatistikKursusDalamanByKehadiran::countKursusByStatus($model->id, 1, $year);
        },
        'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
        'headerOptions' => [
            'style' => 'display: none;',
        ],
        'format' => 'raw',
        //'footer' => StatistikKursusDalamanByBulan::countKursusByStatusTotal(1, $year)
        'pageSummary' => StatistikKursusDalamanByKehadiran::countKursusByStatusTotal(1, $year),

    ],
    [
        'label' => 'JUMLAH MEMOHON',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'format' => 'raw',
        'value' => function ($model) use ($year) {
            return StatistikKursusDalamanByKehadiran::countKursusByStatus($model->id, 2, $year);
        },
        'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
        'headerOptions' => [
            'style' => 'display: none;',
        ],
        'format' => 'raw',
        'pageSummary' => StatistikKursusDalamanByKehadiran::countKursusByStatusTotal(2, $year),

    ],
    [
        'label' => 'MEMOHON',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'format' => 'raw',
        'value' => function ($model) use ($year) {
            return StatistikKursusDalamanByKehadiran::countKursusByStatus($model->id, 9, $year);
        },
        'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
        'pageSummary' => StatistikKursusDalamanByKehadiran::countKursusByStatusTotal(9, $year),

    ],
    // [
    //     'label' => '%',
    //     'vAlign' => 'middle',
    //     'hAlign' => 'center',
    //     'format' => 'raw',
    //     'value' => function ($model) use ($year) {
    //         return StatistikKursusDalamanByKehadiran::countKursusByStatus($model->id, 4, $year);
    //     },
    //     'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
    //     //'footer' => StatistikKursusDalamanByBulan::countKursusByStatusTotal(2, $year).'%'
    // ],
    [
        'label' => 'WALK-IN',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'format' => 'raw',
        'value' => function ($model) use ($year) {
            return StatistikKursusDalamanByKehadiran::countKursusByStatus($model->id, 7, $year);
        },
        'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
        'pageSummary' => StatistikKursusDalamanByKehadiran::countKursusByStatusTotal(7, $year),
    ],
    // [
    //     'label' => '%',
    //     'vAlign' => 'middle',
    //     'hAlign' => 'center',
    //     'format' => 'raw',
    //     'value' => function ($model) use ($year) {
    //         return StatistikKursusDalamanByKehadiran::countKursusByStatus($model->id, 6, $year);
    //     },
    //     'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
    //     //'footer' => StatistikKursusDalamanByBulan::countKursusByStatusTotal(4, $year).'%'
    // ],
    [
        'label' => 'KESELURUHAN',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'format' => 'raw',
        'value' => function ($model) use ($year) {
            return StatistikKursusDalamanByKehadiran::countKursusByStatus($model->id, 3, $year);
        },
        'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
        'pageSummary' => StatistikKursusDalamanByKehadiran::countKursusByStatusTotal(3, $year),

    ],
    [
        'header' => 'JUMLAH PEMOHON <br> YANG TIDAK HADIR',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'format' => 'raw',
        'value' => function ($model) use ($year) {
            return StatistikKursusDalamanByKehadiran::countKursusByStatus($model->id, 5, $year);
        },
        'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
        'headerOptions' => [
            'style' => 'display: none;',
        ],
        'pageSummary' => StatistikKursusDalamanByKehadiran::countKursusByStatusTotal(5, $year),
    ],
    // [
    //     'label' => '%',
    //     'vAlign' => 'middle',
    //     'hAlign' => 'center',
    //     'format' => 'raw',
    //     //                                    'value' => function ($model){
    //     //                                                        return RptStatistikIdp::countStatistics($model->id, 0, 2);
    //     //                                                  },
    //     'value' => function ($model) use ($year) {
    //         return StatistikKursusDalamanByBulan::countKursusByStatus($model->id, 6, $year);
    //     },
    //     'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
    //     'footer' => StatistikKursusDalamanByBulan::countKursusByStatusTotal(6, $year).'%'
    // ],


];

?>
<!---- Hide previous modal screen ---->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#modal").on('hidden.bs.modal', function() {
            $('#modalContent').empty();
        });
    });
</script>
<!--- /Hide previous modal screen ---->
<style>
    a:link {
        color: green;
        background-color: transparent;
        text-decoration: none;
    }

    a:visited {
        color: indigo;
        background-color: transparent;
        text-decoration: none;
    }

    a:hover {
        color: red;
        background-color: transparent;
        text-decoration: underline;
    }

    a:active {
        color: yellow;
        background-color: transparent;
        text-decoration: underline;
    }
</style>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-search"></i>&nbsp;Carian</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php
                $form = ActiveForm::begin([
                    'action' => ['idp/statistik-kehadiran-kursus-dalaman'],
                    'method' => 'get',
                ])
                ?>

                <div class="col-xs-6 col-md-3 col-lg-2">

                    <?= Html::dropDownList('tahun', $tahun, ArrayHelper::map(TblYears::findAll(['admin_status' => 1]), 'year', 'year'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                </div>

                <div class="col-xs-12 col-md-2 col-lg-2">
                    <?= Html::submitButton('<i class="fa fa-search"></i>&nbsp;Cari', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end() ?>
                <!-- </div> -->
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-line-chart"></i>&nbspStatistik Pencapaian Pelaksanaan Kursus Dalaman Mengikut Kalendar Latihan Bagi Tahun <?= $tahun ?>
                    </strong></h2>
                <div class="pull-right">
                    <?=
                    ExportMenu::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => $gridColumnsK,
                        'exportConfig' => [
                            ExportMenu::FORMAT_TEXT => false,
                            ExportMenu::FORMAT_HTML => false,
                            ExportMenu::FORMAT_CSV => false,
                            ExportMenu::FORMAT_EXCEL => true,
                            ExportMenu::FORMAT_PDF => false,
                        ],
                        'dropdownOptions' => [
                            //'label' => 'Export All',
                            'class' => 'btn btn-outline-secondary'
                        ],
                        'filename' => 'Statistik Pencapaian Pelaksanaan Kursus Dalaman Mengikut Kalendar Latihan Bagi Tahun ' . $tahun . ' ' . date('Y-m-d'),
                        'clearBuffers' => true,
                        'stream' => false,
                        'folder' => '@app/web/files/myidp/.',
                        'linkPath' => '/files/myidp/',
                        'batchSize' => 10,
                        //                'deleteAfterSave' => true
                    ]);
                    ?></div>
                <div class="clearfix"></div>

            </div>
            <div class="x_content">

                <?= Tabs::widget([
                    'items' => [
                        [
                            'label' => '',
                            'content' =>
                            GridView::widget([
                                'dataProvider' => $dataProvider,
                                'showPageSummary' => true,
                                'showFooter' => true,
                                'emptyText' => 'Tiada data ditemui.',
                                'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>TIADA DATA</b></i>'],
                                'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                                'beforeHeader' => [
                                    [
                                        'columns' => [
                                            [
                                                'content' => 'BIL',
                                                'options' => [
                                                    'colspan' => 1,
                                                    'rowspan' => 2,
                                                ],
                                                'vAlign' => 'middle',
                                                'hAlign' => 'center'
                                            ],
                                            ['content' => 'BULAN', 'options' => ['colspan' => 1, 'rowspan' => 2]],
                                            [
                                                'content' => 'JUMLAH <br>KURSUS', 'options' => ['colspan' => 1, 'rowspan' => 2],
                                                'vAlign' => 'middle',
                                                'hAlign' => 'center'
                                            ],
                                            [
                                                'content' => 'JUMLAH <br>PEMOHON', 'options' => ['colspan' => 1, 'rowspan' => 2],
                                                'vAlign' => 'middle',
                                                'hAlign' => 'center'
                                            ],
                                            ['content' => 'JUMLAH HADIR', 'options' => ['colspan' => 3, 'rowspan' => 1]],
                                            ['content' => 'JUMLAH PEMOHON <br> TIDAK HADIR', 'options' => ['colspan' => 1, 'rowspan' => 2]],
                                            //['content' => 'TANGGUH', 'options' => ['colspan' => 2]],
                                            //['content' => 'Date', 'options' => ['colspan' => 2, 'class' => 'text-center warning']],
                                        ],

                                    ]
                                ],
                                'columns' => $gridColumnsK,
                            ]),
                            'active' => true
                        ],
                    ],
                ]);
                ?>
            </div> <!-- x_content -->
        </div>
    </div>
</div>