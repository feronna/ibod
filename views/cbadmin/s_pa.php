<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
error_reporting(0);

?> 

<?= $this->render('/cutibelajar/_topmenu') ?>
    <div class="x_panel"> 
        <div class="x_content"> 
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>  
            <div class="x_content">    
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama PA: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12"> 
                        <?=
                        $form->field($model, 'icno')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm'),
                            'options' => ['placeholder' => 'Pilih Nama'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);
                        ?> 
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">JAFPIB: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12"> 
                        <?=
                        $form->field($model, 'DeptID')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\hronline\Department::find()->where(['isActive' => 1])->all(), 'id', 'fullname'),
                            'options' => ['placeholder' => 'Pilih JAFPIB'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);
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
                ['class' => 'yii\grid\SerialColumn',
                    ],
                [
                    'label' => 'Nama',
                    'value' => function($model) {
                if($model->kakitangan)
                {
                       return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>').'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred;
                }
                else
                {
                    return strtoupper($model->icno);
                }
                    },
                    'format' => 'raw',
                ],
//                     [
//                'label' => 'JFPIB',
//                                                     'format' => 'raw',
//
//                'value'=>function ($data) {
//                    return $data->kakitangan->department->shortname;
//                },
//                'filter' => Select2::widget([
//                            'name' => 'jfpiu',
//                            'value' => $jfpiu,
//                            'data' => ArrayHelper::map(app\models\hronline\Department::find()->where(['isActive'=>1])->all(), 'id', 'shortname'),
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                            ],
//                        ]),
//                'vAlign' => 'middle',
//                'hAlign' => 'center',
//            ],
//                
                [
                    'label' => 'Tindakan',
                    'value' => function($model) {
                        return Html::a('<i class="fa fa-trash"></i>', ['delete-pa', 'id' => $model->id], ['class' => 'btn btn-danger btn-sm']);
                    },
                            'format' => 'raw',
                            'contentOptions' => ['class' => 'text-center'],
                            'headerOptions' => ['class' => 'text-center'],
                        ],
                    ];



                    echo GridView::widget([
                     
                        'pager' => [
                            'firstPageLabel' => 'First',
                            'lastPageLabel' => 'Last'
                        ],
                        'dataProvider' => $staff,
                        'filterModel' => true,
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
                            'heading' => '<h2>Rekod PA</h2>',
                        ],
                    ]);
                    ?>
        </div>

    </div> 
