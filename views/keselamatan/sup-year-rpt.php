<?php

use yii\helpers\Html;
use app\models\keselamatan\TblRekod;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\TblYears;
use kartik\widgets\Select2;

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
                    'action' => ['keselamatan/sup-year-rpt'],
                    'method' => 'get',
                ])
                ?>

                <div class="col-xs-6 col-md-3 col-lg-2">

                    <?= Html::dropDownList('tahun', $tahun, ArrayHelper::map(TblYears::findAll(['status' => 1]), 'year', 'year'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
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
                <h2><strong><i class="fa fa-line-chart"></i>&nbspLaporan Prestasi Tahunan Staf Tahun <?= $tahun ?>
                    </strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="pull-left">
                <?php
                $gridColumns = [
                    ['class' => 'yii\grid\SerialColumn'],
                    //                    'nama',
                    [
                        'attribute' => 'CONm',
//                        'footer' => 'Total',
                    ],
                    [
                        'label' => 'Total Working Days',
                        'value' => function ($model) use ($tahun) {
                            return TblRekod::totalWorkingDays($model->ICNO, $tahun);
                        },
                    ],
                    [
                        'label' => 'Late In',
                        'value' => function ($model) use ($tahun) {
                            return TblRekod::totalComplianceStatus($model->ICNO, 'status_in', $tahun);
                        },
                    ],
                    [
                        'label' => 'Early Out',
                        'value' => function ($model) use ($tahun) {
                            return TblRekod::totalComplianceStatus($model->ICNO, 'status_out', $tahun);
                        },
                    ],
                    [
                        'label' => 'Incomplete',
                        'value' => function ($model) use ($tahun) {
                            return TblRekod::totalComplianceStatus($model->ICNO, 'incomplete', $tahun);
                        },
                    ],
                    [
                        'label' => 'Absent',
                        'value' => function ($model) use ($tahun) {
                            return TblRekod::totalComplianceStatus($model->ICNO, 'absent', $tahun);
                        },
                    ],
                    [
                        'label' => 'External',
                        'value' => function ($model) use ($tahun) {
                            return TblRekod::totalComplianceStatus($model->ICNO, 'external', $tahun);
                        },
                    ],

                ];

                echo ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                    'clearBuffers' => true,
                    'exportConfig' => [
                        ExportMenu::FORMAT_CSV => false,
                        ExportMenu::FORMAT_EXCEL => false,
                        ExportMenu::FORMAT_HTML => false,
                    ],
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