<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm; 
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?> 

<?= $this->render('menu') ?>  
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel"> 
        <div class="x_content"> 
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>  
            <div class="x_content">    
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Carian Hospital:
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12"> 
                        <?=
                        $form->field($model, 'searching')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\guarantee_letter\TblHospital::find()->all(), 'id', 'nama'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);
                        ?> 
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Hospital: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12"> 
                        <?=
                        $form->field($model, 'nama')->textarea()->label(false);
                        ?> 
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Daerah: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12"> 
                        <?=
                        $form->field($model, 'daerah')->textarea()->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group text-center">
                    <?= Html::submitButton('Tambah', ['class' => 'btn btn-primary']) ?>
                </div>

            </div>   

            <?php ActiveForm::end(); ?> 
        </div>
    </div>
    <div class="x_panel"> 


        <div class="table-responsive">

            <?php
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label' => 'Nama',
                    'value' => function($model) {
                        return $model->nama;
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'Daerah',
                    'value' => function($model) {
                        return $model->daerah;
                    },
                    'format' => 'raw',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                ],
//                [
//                    'label' => 'Tindakan',
//                    'value' => function($model) {
//                        return Html::a('<i class="fa fa-trash"></i>', ['delete-hospital', 'id' => $model->id], ['class' => 'btn btn-danger btn-sm']);
//                    },
//                            'format' => 'raw',
//                            'contentOptions' => ['class' => 'text-center'],
//                            'headerOptions' => ['class' => 'text-center'],
//                        ],
                    ];



                    echo GridView::widget([
                        'dataProvider' => $hospital,
                        'columns' => $gridColumns,
                        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                        'beforeHeader' => [
                            [
                                'columns' => [],
                                'options' => ['class' => 'skip-export'] // remove this row from export
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
                            'heading' => '<h2>Rekod Hospital</h2>',
                        ],
                    ]);
                    ?>
        </div> 
    </div>  
</div>