<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?> 

<div class="col-md-12 col-sm-12 col-xs-12">

    <div class="x_panel"> 
        <div class="x_content">
            <?php $form = ActiveForm::begin(); ?>

            <div class="col-md-3 col-sm-3 col-xs-3 col-md-offset-8 col-sm-offset-8 col-xs-offset-8">
                <?=
                $form->field($search, 'icno')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\TempHrmis::find()->all(), 'icno', 'kakitangan.CONm'),
                        'options' => ['placeholder' => 'Nama Staff'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
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
        <div class="x_content">  


            <div class="table-responsive">

                <?php
                $gridColumns = [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Nama Kakitangan',
                        'value' => function($model) {
                            return ucwords(strtolower($model->kakitangan->CONm));                       },
                        'format' => 'raw',
                    ],
                     
                   [
                        'label' => 'UMSPER',
                        'value' => function($model) {
                            return ucwords(strtolower($model->kakitangan->COOldID));  
                        },
                        'format' => 'raw',
                    ],
                     [
                        'label' => 'No. K/P',
                        'value' => function($model) {
                             if ($model->kakitangan->NatCd == "MYS") {
                                return $model->kakitangan->ICNO;
                            } else {
                                return $model->kakitangan->latestPaspot;
                            }
                        },
                        'format' => 'raw',
                    ],
                                
                    [
                        'label' => 'Tarikh Kuatkuasa',
                        'value' => function($model) {
                            return ucwords(strtolower($model->kakitangan->staffRocBatch->staffRoc3->SR_DATE_FROM));   
                        },
                        'format' => 'raw',
                    ],
                                
                     [
                        'label' => 'Gaji Pokok',
                        'value' => function($model) {
                            return ucwords(strtolower($model->kakitangan->gajiBasic));   
                        },
                        'format' => 'raw',
                    ],
                      
                   
                    
                        ];



                        echo GridView::widget([
                            'dataProvider' => $permohonan,
                            'columns' => $gridColumns,
                            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                            'beforeHeader' => [
                                [
                                    'columns' => [], 
                                ]
                            ],
                            'toolbar' => [ 
                            ],
                            'bordered' => true,
                            'striped' => false,
                            'condensed' => false,
                            'responsive' => true,
                            'hover' => true, 
                            'panel' => [
                                'type' => GridView::TYPE_DEFAULT,
                                'heading' => '<h2>Senarai Kakitangan</h2>',
                            ],
                        ]);
                        ?>
            </div>


        </div>
    </div>  

</div>  

