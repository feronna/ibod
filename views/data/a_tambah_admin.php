<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?> 

<?= $this->render('_topmenu') ?>
    <div class="x_panel"> 
        <div class="x_content"> 
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>  
            <div class="x_content">    
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Pegawai: <span class="required" style="color:red;">*</span>
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Level: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12"> 
                        <?=
                        $form->field($model, 'access')->widget(Select2::classname(), [
                            'data' => ['2' => 'TEAM DATA','3'=>'ADMIN - HRMIS'],
                            'options' => ['placeholder' => 'Pilih Level'],
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
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label' => 'Nama',
                    'value' => function($model) {
                if($model->kakitangan)
                {
                        return $model->kakitangan->CONm;
                }
                else
                {
                    return strtoupper($model->icno);
                }
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'Level',
                    'value' => function($model) {
                        if ($model->access == 1) {
                            return '<span class="label label-warning">Pentadbir Sistem</span>';
                        } 
                         elseif ($model->access == 2) {
                            return '<span class="label label-info">TEAM DATA </span>';
                        } 
                        elseif ($model->access == 3) {
                            return '<span class="label label-success">ADMIN - HRMIS </span>';
                        } 
                       
                    },
                    'format' => 'raw',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                ],
                [
                    'label' => 'Tindakan',
                    'value' => function($model) {
                        return Html::a('<i class="fa fa-trash"></i>', ['delete-admin', 'id' => $model->id], ['class' => 'btn btn-danger btn-sm']);
                    },
                            'format' => 'raw',
                            'contentOptions' => ['class' => 'text-center'],
                            'headerOptions' => ['class' => 'text-center'],
                        ],
                    ];



                    echo GridView::widget([
                        'dataProvider' => $staff,
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
                            'heading' => '<h2>Rekod Akses</h2>',
                        ],
                    ]);
                    ?>
        </div>

    </div> 
