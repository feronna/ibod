<?php

use app\models\kehadiran\TblYears;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\widgets\Pjax;

use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->params['breadcrumbs'][] = $this->title;
?>

<?php // echo $this->render('_search', ['model' => $searchModel]);      
?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Searching</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php
                $form = ActiveForm::begin([
                    'action' => ['gcr-application-list'],
                    'method' => 'get',
                    'options' => [
                        'data-pjax' => 1
                    ],
                ]);
                ?>

                <div class="form-group">
                    <div class=" col-md-2 col-sm-2 col-xs-12">
                        <?=
                        $form->field($searchModel, 'jenis_carian')->label(false)->widget(Select2::classname(), [
                            'data' => ["0" => "IC", "1" => "Nama", "2" => "UMSPER"],
                            'options' => ['placeholder' => 'Jenis Carian', 'class' => 'form-control col-md-2 col-xs-12','value' => 1, 'selected' => true],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                    <div class=" col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($searchModel, 'carian_data')->textInput(['placeholder' => 'Nama / Nombor IC / ID'])->label(false) ?>
                    </div>
                 

                </div>
                <div class="form-group">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <?=
                            $form->field($searchModel, 'year')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(TblYears::find()->all(), 'year', 'year'),
                                'options' => ['placeholder' => 'Tahun', 'class' => 'form-control col-md-4 col-xs-12','selected' => true],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                   

                </div>

                <div class="form-group">
                <div class="col-md-3 col-sm-3 col-xs-12">

                    <?= Html::submitButton('<i class="fa fa-microchip"></i> Search', ['class' => 'btn btn-primary']) ?>
                    <?= Html::resetButton('<i class="fa fa-repeat"></i> Reset', ['class' => 'btn btn-default']) ?>
                </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

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

                    [
                        'attribute' => 'Nama Pemohon',
                        'value' => 'kakitangan.CONm',
                    ],
                    [
                        'attribute' => 'JFPIB',
                        'value' => 'department.shortname',
                    ],
                    [
                        'attribute' => 'Mohon',
                        'value' => 'mohon_dt',

                    ],
                    [
                        'attribute' => 'GCR Dimohon',
                        'value' => 'gcr_applied',

                    ],
                    [
                        'attribute' => 'CBTH Dimohon',
                        'value' => 'cbth_applied',
                    ],
                    [
                        'attribute' => 'status',
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'Tindakan',
                        'template' => '{delete}',
                        'contentOptions' => ['style' => 'padding:0px 0px 0px 30px;vertical-align: middle;'],
                    ],
                 
                ];

                echo ExportMenu::widget([
                    'dataProvider' => $dataProviders,
                    'columns' => $gridColumns,
                    'clearBuffers' => true,
                    'filename' => 'Senarai Permohonan GCR dan CBTH',

                ]
            
            );
                ?>
            </div>
            
            <div class="x_content">
                <?php


                echo GridView::widget([
                    'dataProvider' => $dataProviders,
                    'columns' => $gridColumns,
                    // 'filterModel' => $searchModel,
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

