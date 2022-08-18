<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?> 
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1162], 'vars' => []]); ?>
<div class="col-md-12 col-sm-12 col-xs-12">

    <div class="x_panel"> 
        <div class="x_content">
            <?php $form = ActiveForm::begin(); ?>

            <div class="col-md-3 col-sm-3 col-xs-3 col-md-offset-8 col-sm-offset-8 col-xs-offset-8">
                <?=
                $form->field($search, 'ICNO')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->where(["NOT LIKE",'Status', '6'])->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => 'Nama Kakitangan'],
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
                            return $model->CONm;                       },
                        'format' => 'raw',
                    ],
                     
                   [
                        'label' => 'No. K/P',
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
                        'label' => 'Status Lantikan',
                        'value' => function($model) {
                            return $model->statusLantikan->ApmtStatusNm;                       },
                        'format' => 'raw',
                    ],  
                                    
                   [
                        'label' => 'J/F/P/I/U',
                        'value' => function($model) {
                            return ucwords(strtoupper($model->department->fullname));                       },
                        'format' => 'raw',
                    ],  
                    
                    [
            'label' => 'Tindakan',
            'format' => 'raw',
            'value' => function ($data) {
                return Html::a('<i class="fa fa-eye">', ["klinikpanel/papar", 'id' => $data->ICNO]);
                // return Html::button('', ['id' => 'modalButton', 'value' => Url::to(['tindakan_ketua_jabatan', 'id' => $data->id]), 'class' => 'fa fa-eye mapBtn']);
            },
//            'headerOptions' => ['class' => 'text-center'],
//            'contentOptions' => ['class' => 'text-center'],
                      'vAlign' => 'middle',
                        'hAlign' => 'center',
        ],
                                                                    
                        ];
                        
                        echo GridView::widget([
                            'dataProvider' => $staff,
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

