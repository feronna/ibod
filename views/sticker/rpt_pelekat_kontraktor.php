<?php

use yii\helpers\Html;
use kartik\form\ActiveForm; 
use kartik\select2\Select2;  
use yii\widgets\Pjax;
use kartik\grid\GridView; 
use kartik\date\DatePicker;
?>

 <?= $this->render('menu') ?> 
    <div class="x_panel">
        <div class="x_title">
            <h2>Carian</h2> 
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
            <?php
            $form = ActiveForm::begin([
                        'action' => ['laporan-pelekat-kontraktor'],
                        'method' => 'get',
                        'options' => [
                            'data-pjax' => 1
                        ],
                        'fieldConfig' => ['autoPlaceholder' => true,
                        ],
            ]);
            ?>
 
            <div class="col-md-2 col-sm-2 col-xs-2">
                <?=$form->field($searchModel, 'apply_type')->label(false)->widget(Select2::classname(), [
                    'data' => ['BARU'=>'BARU','LANJUTAN' => 'LANJUTAN', 'ROSAK' => 'ROSAK', 'HILANG' => 'HILANG'],
                    'options' => ['placeholder' => 'JENIS', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div> 
            <div class="col-md-3 col-sm-3 col-xs-3">
                <?=$form->field($searchModel, 'mohon_date')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'HARIAN'],
                    'pluginOptions' => [ 
                        'format' => 'yyyy-mm-dd'
                    ]
                ])->label(false);
                ?>
            </div> 
            <div class="col-md-3 col-sm-3 col-xs-3">
                <?=$form->field($searchModel, 'bulanan')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'BULAN & TAHUN'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'startView' => 'year',
                        'minViewMode' => 'months',
                        'format' => 'mm-yyyy'
                    ]
                ])->label(false);
                ?>
            </div>  
             
            <div class="col-md-1 col-sm-1 col-xs-1">
                <div class="form-group">
                    <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?> 
                </div>
            </div>

            <?php ActiveForm::end(); ?> 
        </div>
    </div>
 
 <div class="x_panel">
<div class="table-responsive">     
            <?php Pjax::begin(); ?>
            <?php
            $gridColumns = [
                    ['class' => 'yii\grid\SerialColumn'],
                [
                        'label' => 'Kontraktor',
                        'value' => function($model) {
                            return $model->kontraktor? $model->kontraktor->apsu_lname:'';
                        },
                    ], 
                                [
                        'label' => 'Nama',
                        'value' => function($model) {
                            return  $model->kenderaan? $model->kenderaan->veh_owner:'';
                        },
                    ],
                                [
                        'label' => 'Jenis',
                        'value' => function($model) {
                            return $model->apply_type;
                        },
                    ],
                                [
                        'label' => 'Tarikh Mohon',
                        'value' => function($model) {
                            return $model->mohon_date;
                        },
                    ],
                                [
                        'label' => 'No. Kenderaan',
                        'value' => function($model) {
                            return $model->kenderaan? $model->kenderaan->reg_number:'';
                        },
                    ],
                                [
                        'label' => 'No. Siri',
                        'value' => function($model) {
                            return $model->no_siri;
                        },
                    ],
                                [
                        'label' => 'No. Resit',
                        'value' => function($model) {
                            return $model->no_resit;
                        },
                    ],
                                [
                        'label' => 'Tarikh Mula',
                        'value' => function($model) {
                            return $model->expired_date;
                        },
                    ],
                                [
                        'label' => 'Tarikh Tamat',
                        'value' => function($model) {
                            return $model->expired_date_2;
                        },
                    ],
                ];
            echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumns,
                            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                            'beforeHeader' => [
                                [
                                    'columns' => [],
                                    'options' => ['class' => 'skip-export'] // remove this row from export
                                ]
                            ],
                            'toolbar' => [
                                '{export}',
                                '{toggleData}'
                            ],
                            'bordered' => true,
                            'striped' => false,
                            'condensed' => false,
                            'responsive' => true,
                            'hover' => true, 
                            'panel' => [
                                'type' => GridView::TYPE_DEFAULT,
                                'heading' => '<h2>Laporan Pelekat Kontraktor</h2>',
                            ],
                        ]);
             
                    ?>
                    <?php Pjax::end(); ?>
        </div>
     </div>

