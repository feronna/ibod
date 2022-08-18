<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use kartik\grid\GridView;
use app\models\hronline\Department;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\GredJawatan;
use app\models\saman\SamanOld;
use yii\helpers\Url;
use app\models\saman\SamanStatus;
use kartik\export\ExportMenu;

?>
<?= $this->render('/saman/_menu') ?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian Saman</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php
                $form = ActiveForm::begin([
                    'action' => ['saman-status'],
                    'method' => 'get',
                    'options' => [
                        'data-pjax' => 1
                    ],
                ]);
                ?>
            
                <?= $form->field($searchModel, 'NOSAMAN')->textInput(['placeholder' => 'NO SAMAN', 'autofocus' => 'autofocus',])->label(false) ?>
                <?= $form->field($searchModel, 'icno')->textInput(['placeholder' => 'ICNO', 'autofocus' => 'autofocus',])->label(false) ?>
                <?=
                $form->field($searchModel, 'nokenderaan')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(SamanOld::find()->all(), 'NO_KENDERAAN', 'NO_KENDERAAN'),
                    'options' => ['placeholder' => 'NO Kenderaan', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            
            
                <?=
                $form->field($searchModel, 'STATUS')->label(false)->widget(Select2::classname(), [
                    'data' => ['PAID' => 'PAID', 'PENDING' => 'PENDING'],
                    'options' => ['placeholder' => 'Status Saman', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>


                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-microchip"></i> Search', ['class' => 'btn btn-primary']) ?>
                    <?= Html::resetButton('<i class="fa fa-repeat"></i> Reset', ['class' => 'btn btn-default']) ?>
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

                    'NOSAMAN',
                            [
                                'label' => 'NO KENDERAAN',
                                'format' => 'raw',
                                'value' => 'saman.NO_KENDERAAN'
                            ],
                            [
                                'label' => 'TARIKH MASUK',
                                'format' => 'raw',
                                'value' => 'INSERTDATE'
                            ],
                            [
                                'label' => 'TARIKH BAYAR',
                                'format' => 'raw',
                                'value' => 'paiddate'
                            ],
                            [
                                'label' => 'JUMLAH SAMAN',
                                'format' => 'raw',
                                'value' => 'AMOUNT_PENDING'
                            ],
                            [
                                'label' => 'JUMLAH DIBAYAR',
                                'format' => 'raw',
                                'value' => 'AMOUNT_PAID'
                            ],
                            [
                                'label' => 'JUMLAH KUNCI',
                                'format' => 'raw',
                                'value' => 'AMNKUNCI'
                            ],
                            [
                                'label' => 'JUMLAH KUNCI DIBAYAR',
                                'format' => 'raw',
                                'value' => 'AMNKUNCI_PAID'
                            ],
                            'STATUS',

                            [
                                'label' => 'CATATAN',
                                'format' => 'raw',
                                'value' => 'remark'
                            ],
                            [
                                'label' => 'View',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    return Html::a('<i class="fa fa-eye">', ["saman/bayar-saman", 'id' => $data->NOSAMAN]);
                                },
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                 
                ];

                echo ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                    'clearBuffers' => true,
                    'filename' => 'Laporan Saman BKUMS',

                ]
            
            );
                ?>
            </div>
            
            <div class="x_content">
                <?php


                echo GridView::widget([
                    'dataProvider' => $dataProvider,
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