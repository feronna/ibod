<?php

use yii\helpers\Html;
use kartik\form\ActiveForm; 
use kartik\select2\Select2;  
use yii\widgets\Pjax;
use kartik\grid\GridView; 
use yii\helpers\ArrayHelper;
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
                        'action' => ['semakan-kenderaan-kontraktor'],
                        'method' => 'get',
                        'options' => [
                            'data-pjax' => 1
                        ],
                        'fieldConfig' => ['autoPlaceholder' => true,
                        ],
            ]);
            ?>
 
            <div class="col-md-3 col-sm-3 col-xs-3">
                <?=$form->field($searchModel, 'id_kontraktor')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\app\models\esticker\TblKontraktor::find()->all(), 'apsu_suppid','apsu_lname'),
                    'options' => ['placeholder' => 'SYARIKAT', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div> 
            <div class="col-md-3 col-sm-3 col-xs-3">
                <?=$form->field($searchModel, 'veh_user')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\app\models\esticker\TblStickerKontraktor::find()->all(), 'veh_user','veh_user'),
                    'options' => ['placeholder' => 'PENGGUNA', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div> 
            <div class="col-md-2 col-sm-2 col-xs-2">
                <?=$form->field($searchModel, 'v_co_icno')->label(false)->textInput();?> 
            </div>  
            
            <div class="col-md-2 col-sm-2 col-xs-2">
                <?=$form->field($searchModel, 'reg_number')->label(false)->textInput();?> 
            </div> 
            <div class="col-md-2 col-sm-2 col-xs-2">
                <div class="form-group">
                    <?= Html::a('Reset',['semakan-kenderaan-kontraktor'] ,['class' => 'btn btn-danger']) ?> 
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
                            return $model->biodata? $model->biodata->apsu_lname:'';
                        },
                    ], 
                                [
                        'label' => 'No. K/P',
                        'value' => function($model) {
                            return  $model->v_co_icno? $model->v_co_icno:'';
                        },
                    ],
                                [
                        'label' => 'Nama Pengguna',
                        'value' => function($model) {
                            return  $model->veh_user? $model->veh_user:'';
                        },
                    ],
                                [
                        'label' => 'Jenis Kenderaan',
                        'value' => function($model) {
                            return $model->rel_owner_user? $model->rel_owner_user:'';
                        },
                    ], 
                                [
                        'label' => 'No. Kenderaan',
                        'value' => function($model) {
                            return $model->reg_number? $model->reg_number:'';
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
                                'heading' => '<h2>Rekod Kenderaan Kontraktor</h2>',
                            ],
                        ]);
             
                    ?>
                    <?php Pjax::end(); ?>
        </div>
     </div>

