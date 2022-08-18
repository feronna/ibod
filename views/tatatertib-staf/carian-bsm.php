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
                        'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => 'Nama Staff'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                ?>
                
                
            </div>
            
             <div class="col-md-3 col-sm-3 col-xs-3 col-md-offset-8 col-sm-offset-8 col-xs-offset-8">
                <?=
                $form->field($search, 'icno')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->all(), 'ICNO', 'ICNO'),
                        'options' => ['placeholder' => 'ICNO Staff'],
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
                        'label' => 'No KP / Paspot',
                        'value' => function($model) {
                             if ($model->biodata->NatCd == "MYS") {
                                return $model->biodata->ICNO;
                            } else {
                                return $model->biodata->latestPaspot;
                            }
                        },
                        'format' => 'raw',
                    ],
                                
                    [
                        'label' => 'UMSPER',
                       'value' => function($model) {
                       return ucwords(strtolower($model->biodata->COOldID)); },
                        'format' => 'raw',
                    ],
                                
                     [
                        'label' => 'Nama Pegawai',
                        'value' => function($model) {
                            return ucwords(strtolower($model->biodata->CONm)); },
                        'format' => 'raw',
                    ],
            
                    [
                        'label' => 'Jawatan dan Gred',
                        'value' => function($model) {
                            return $model->biodata->jawatan->nama . " (" . $model->biodata->jawatan->gred . "))";},
                        'format' => 'raw',
                    ],
                                    
                    [
                        'label' => 'Jabatan',
                        'value' => function($model) {
                            return ucwords(strtolower($model->biodata->displayDepartment)); },
                        'format' => 'raw',
                    ],   
       
                    [
                        'label' => 'Jenis Lantikan',
                        'value' => function($model) {
                            return ucwords(strtolower($model->biodata->statusLantikan->ApmtStatusNm));  },
                        'format' => 'raw',
                    ],   
                         
                   [
                        'label' => 'Status Lantikan',
                        'value' => function($model) {
                            return ucwords(strtolower($model->biodata->displayServiceStatus));  },
                        'format' => 'raw',
                    ],   
                                    
                    [
                            'label'=>'Tindakan',
                            'format' => 'raw',
                       
                              'hAlign' => 'center',
                              'vAlign' => 'middle',
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
                                'heading' => '<h2>SENARAI KAKITANGAN</h2>',
                            ],
                        ]);
                        ?>
            </div>


        </div>
    </div>  

</div>  

