<?php

use yii\helpers\Html;
use app\models\kehadiran\TblRekod;
use app\models\kehadiran\TblWarnaKad;
use yii\widgets\ActiveForm;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\TblYears;

//use Author;
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-search"></i>&nbsp;Search</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php
                $form = ActiveForm::begin([
                    'id' => 'Senarai-Warna-Kad',
                    //                            'options' => ['class' => 'form-horizontal'],
                    'action' => ['kehadiran/staf-color-list'],
                    'method' => 'get',
                ])
                ?>

                <div class="col-xs-12 col-md-5 col-lg-3">
                    <?= Html::dropDownList('year', $year, ArrayHelper::map(TblYears::findAll(['status' => 1]), 'year', 'year'), ['class' => 'form-control col-md-4 col-sm-4 col-xs-12']); ?>
                    <br><br>
                    <?= Html::submitButton('<i class="fa fa-search"></i>&nbsp;Search', ['class' => 'btn btn-primary']) ?>

                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-bar-chart"></i>&nbsp;Card Color Summary <?= $year ?></strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-striped table-sm jambo_table table-bordered">
                    <thead>
                        <tr class="headings">
                            <th class="text-center" style="text-align:right;width:30%">CARD COLOR</th>
                            <th class="text-center">YELLOW</th>
                            <th class="text-center">GREEN</th>
                            <th class="text-center">RED</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center" style="text-align:right;font-weight:bold">TOTAL</td>
                            <td class="text-center" style="text-align:center;font-weight:bold"><?= TblWarnaKad::totalByCardColor($year, $icno, 'YELLOW') ?></td>
                            <td class="text-center" style="text-align:center;font-weight:bold"><?= TblWarnaKad::totalByCardColor($year, $icno, 'GREEN') ?></td>
                            <td class="text-center" style="text-align:center;font-weight:bold"><?= TblWarnaKad::totalByCardColor($year, $icno, 'RED') ?></td>
                        </tr>
                        <tr>
                            <td class="text-center" style="text-align:right;font-weight:bold;background-color:bisque">PERFORMANCE INDICATOR</td>
                            <td colspan="3" class="text-center" style="text-align:left;font-weight:bold;background-color:bisque"><?= TblWarnaKad::prestasiWarnaKad($year, $icno) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-line-chart"></i>&nbsp;Card Color List <?= $year ?></strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="pull-left">
                <?php
                $gridColumns = [
                    ['class' => 'yii\grid\SerialColumn', 'footer' => '-'],
                    [
                        'attribute' => 'monthName',
                        'footer' => 'Total',
                    ],
                    [
                        'attribute' => 'ketidakpatuhan',
                        'footer' => \app\models\kehadiran\MonthData::getTotal($dataProvider->models, 'ketidakpatuhan'),
                    ],
                    [
                        'attribute' => 'approved',
                        'footer' => \app\models\kehadiran\MonthData::getTotal($dataProvider->models, 'approved'),
                    ],
                    [
                        'attribute' => 'disapproved',
                        'footer' => \app\models\kehadiran\MonthData::getTotal($dataProvider->models, 'disapproved'),
                    ],
                    [
                        'attribute' => 'color',
                        'footer' => '-',
                    ],
                ];

                echo ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                    'clearBuffers' => true,
                    'exportConfig' => [
                        ExportMenu::FORMAT_TEXT => false,
                        ExportMenu::FORMAT_HTML => false,
                        ExportMenu::FORMAT_EXCEL => false,
                        ExportMenu::FORMAT_EXCEL_X => false,
                        ExportMenu::FORMAT_CSV => false,
                        ExportMenu::FORMAT_PDF => [
                            'pdfConfig' => [
                                'methods' => [
                                    'SetTitle' => "ICNO : $icno",
                                    'SetSubject' => "ICNO : $icno",
                                    'SetHeader' => ["$icno||Generated On: " . date("r")],
                                    'SetFooter' => ['|Page {PAGENO}|'],
                                    //                                    'SetAuthor' => 'Kartik Visweswaran',
                                    //                                    'SetCreator' => 'Kartik Visweswaran',
                                    //                                    'SetKeywords' => 'Krajee, Yii2, Export, PDF, MPDF, Output, GridView, Grid, yii2-grid, yii2-mpdf, yii2-export',
                                ]
                            ]
                        ],
                    ]
                ]);
                ?>
            </div>
            <div class="x_content">

                <!--<div class="table-responsive">-->
                <?php
                // Control your pjax options
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                    'responsiveWrap' => true,
                    'responsive' => true,
                    'hover' => true,
                    'showFooter' => true,
                    'pjax' => true,
                    'pjaxSettings' => [
                        'neverTimeout' => true,
                    ]
                ]);
                ?>
            </div>
        </div>
    </div>
</div>