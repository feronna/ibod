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
                $form->field($search, 'ICNO')->widget(Select2::classname(), [
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
                             if ($model->NatCd == "MYS") {
                                return $model->ICNO;
                            } else {
                                return $model->latestPaspot;
                            }
                        },
                        'format' => 'raw',
                    ],
                                
                    [
                        'label' => 'UMSPER',
                       'value' => function($model) {
                       return ucwords(strtolower($model->COOldID)); },
                        'format' => 'raw',
                    ],
                                
                     [
                        'label' => 'Nama Pegawai',
                        'value' => function($model) {
                            return ucwords(strtolower($model->CONm)); },
                        'format' => 'raw',
                    ],
            
                    [
                        'label' => 'Jawatan dan Gred',
                        'value' => function($model) {
                            return $model->jawatan->nama . " (" . $model->jawatan->gred . "))";},
                        'format' => 'raw',
                    ],
                                    
                    [
                        'label' => 'Jabatan',
                        'value' => function($model) {
                            return ucwords(strtolower($model->displayDepartment)); },
                        'format' => 'raw',
                    ],   
       
                    [
                        'label' => 'Jenis Lantikan',
                        'value' => function($model) {
                            return ucwords(strtolower($model->statusLantikan->ApmtStatusNm));  },
                        'format' => 'raw',
                    ],   
                         
                   [
                        'label' => 'Status Lantikan',
                        'value' => function($model) {
                            return ucwords(strtolower($model->displayServiceStatus));  },
                        'format' => 'raw',
                    ],   
                                    
                    [
                            'label'=>'Tindakan',
                            'format' => 'raw',
                            'value'=>function ($data){
                       
                            //  return  Html::button('<i class="fa fa-info" aria-hidden="true"></i> INFO', ['value' => \yii\helpers\Url::to(['keterangan-log', 'id' => $data->id]), 'class' => 'mapBtn btn-sm btn-danger btn-block']);
                                  return Html::a('<i class="fa fa-eye">', ["brp/view", 'ICNO' => $data->ICNO]) ;          
                            },
                              'hAlign' => 'center',
                              'vAlign' => 'middle',
                        ],
                       [
                            'label'=>'Tindakan',
                            'format' => 'raw',
                            'value'=>function ($data){
                       
                            //  return  Html::button('<i class="fa fa-info" aria-hidden="true"></i> INFO', ['value' => \yii\helpers\Url::to(['keterangan-log', 'id' => $data->id]), 'class' => 'mapBtn btn-sm btn-danger btn-block']);
                                  return Html::a('<i class="fa fa-book" aria-hidden="true"></i>', ['book','ICNO'=>$data->ICNO], ['target'=>'_blank']);
                            },
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

