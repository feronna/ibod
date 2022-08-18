<?php

use yii\helpers\Html;
use app\models\kehadiran\TblRekod;
use yii\widgets\ActiveForm;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\TblYears;
use kartik\widgets\Select2;

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
                    'id' => 'pantau-kehadiran',
                    //                            'options' => ['class' => 'form-horizontal'],
                    'action' => ['kehadiran/sup-mth-rpt'],
                    'method' => 'get',
                ])
                ?>

                <div class="col-xs-6 col-md-3 col-lg-2">

                    <?= Html::dropDownList('tahun', $tahun, ArrayHelper::map(TblYears::findAll(['status' => 1]), 'year', 'year'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                </div>

                <div class="col-xs-6 col-md-3 col-lg-2">
                    <?= Html::dropDownList('bulan', $today, ['01' => 'Januari', '02' => 'Februari', '03' => 'Mac', '04' => 'April', '05' => 'Mei', '06' => 'Jun', '07' => 'Julai', '08' => 'Ogos', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Disember'], ['class' => 'form-control col-md-4 col-sm-4 col-xs-12']); ?>
                </div>
                <?php if ($isAdmin) { ?>
                    <div class="col-xs-12 col-md-3 col-lg-6">
                        <?= Select2::widget([
                            'name' => 'dept_id',
                            'value' => $dept_id,
                            // 'attribute' => 'state_2',
                            'data' => ArrayHelper::map($model_dept, 'id', 'fullname'),
                            'options' => ['placeholder' => 'SELECT JFPIB'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                <?php } ?>
                <div class="col-xs-12 col-md-2 col-lg-2">
                    <?= Html::submitButton('<i class="fa fa-search"></i>&nbsp;Search', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end() ?>
                <!-- </div> -->
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-line-chart"></i>&nbsp;Staff Attendance Summary</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="pull-left">
                <?php
                $gridColumns = [
                    ['class' => 'yii\grid\SerialColumn'],
                    //                    'nama',
                    [
                        'attribute' => 'nama',
                        'footer' => 'Total',
                    ],
                    [
                        'attribute' => 'total_day',
                        'footer' => \app\models\kehadiran\MonthData::getTotal($dataProvider->models, 'total_day'),
                    ],
                    [
                        'attribute' => 'late_in',
                        'footer' => \app\models\kehadiran\MonthData::getTotal($dataProvider->models, 'late_in'),
                    ],
                    [
                        'attribute' => 'early_out',
                        'footer' => \app\models\kehadiran\MonthData::getTotal($dataProvider->models, 'early_out'),
                    ],
                    [
                        'attribute' => 'incomplete',
                        'footer' => \app\models\kehadiran\MonthData::getTotal($dataProvider->models, 'incomplete'),
                    ],
                    [
                        'attribute' => 'absent',
                        'footer' => \app\models\kehadiran\MonthData::getTotal($dataProvider->models, 'absent'),
                    ],
                    [
                        'attribute' => 'external',
                        'footer' => \app\models\kehadiran\MonthData::getTotal($dataProvider->models, 'external'),
                    ],
                ];

                echo ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                    'clearBuffers' => true,
                ]);
                ?>
            </div>
            <div class="x_content">
                <?php
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