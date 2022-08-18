<?php

use app\models\cuti\TblRecords;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\RefWp;
use app\models\kehadiran\TblYears;
//use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\grid\GridView;
use app\widgets\TopMenuWidget;
use kartik\daterange\DateRangePicker;
use kartik\export\ExportMenu;


$this->title = 'Report';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php 
$yr = $year;
// echo $this->render('_search', ['model' => $searchModel]);     

?>
<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-search"></i>&nbsp;<strong>Carian/<i>Search</i></strong></h2>
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <?= Html::beginForm(['report-leave-list'], 'GET'); ?>
        <div class="col-md-6 col-sm-6 col-xs-12">

            <?php echo Html::dropDownList('id', $id, ArrayHelper::map($jenis_cuti, 'jenis_cuti_id', 'jenis_cuti_catatan'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
            <br>
            <br>
            <?= Html::dropDownList('year', $year, $data, ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
            <br>
            <br>
            <br>

            <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']); ?>
            <?= Html::endForm(); ?>
        </div>
    </div>
    <?php if($var){ ?>


    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong><i class="fa fa-line-chart"></i>&nbsp;</strong></h2>

                    <div class="clearfix"></div>
                </div>
                <div class="pull-left">
                    <?php
                    $gridColumns = [

                        ['class' => 'yii\grid\SerialColumn'],
                        //                    'nama',

                        // [
                        //     'attribute' => 'Nama',
                        //     'value' => 'kakitangan.CONm',
                        // ],
                        [
                            'attribute' => 'JFPIB',
                            'value' => 'department.shortname',
                        ],
                        [
                            'attribute' => 'Jenis Cuti',
                            'value' => 'jenisCuti.jenis_cuti_nama',

                        ],

                        [
                            'attribute' => 'total (days)',
                            'value' => function ($data) {
                                $total = TblRecords::getSums($data->jenis_cuti_id, $data->department->id, Yii::$app->getRequest()->getQueryParam('year'));
                                return $total;
                            }
                            // 'value' => TblRecords::getTotal($dataProvider->models, 'tempoh'),

                        ],
                        [
                            'attribute' => 'total (Application)',
                            'value' =>  function ($data) {
                                $total = TblRecords::getTotalApp($data->jenis_cuti_id, $data->department->id, Yii::$app->getRequest()->getQueryParam('year'));
                                return $total;
                            },

                        ],
                        // [
                        //     'attribute' => 'external',
                        // 'footer' => \app\models\kehadiran\MonthData::getTotal($dataProvider->models, 'external'),
                        // ],
                    ];

                    echo ExportMenu::widget(
                        [
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumns,
                            'clearBuffers' => true,
                            'filename' => 'Senarai Cuti',

                        ]

                    );
                    ?>
                </div>

                <div class="x_content">
                    <?php


                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => $gridColumns,
                        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                        'responsiveWrap' => true,
                        'responsive' => true,
                        'hover' => true,
                        'showFooter' => true,
                        'hover' => true,
                        'floatHeader' => true,
                        'floatHeaderOptions' => [
                            'position' => 'absolute',
                        ],
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
    <?php } ?>