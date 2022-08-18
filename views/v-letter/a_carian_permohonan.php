<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?> 
<?= $this->render('menu') ?>
<div class="col-md-12 col-sm-12 col-xs-12">

    <div class="x_panel"> 
        <div class="x_content">
            <?php $form = ActiveForm::begin(); ?>

            <div class="col-md-3 col-sm-3 col-xs-3 col-md-offset-8 col-sm-offset-8 col-xs-offset-8">
                <?=
                $form->field($search, 'ICNO')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm'),
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
                        'label' => 'Nama Pegawai',
                        'value' => function($model) {
                            return ucwords(strtolower($model->biodata->CONm));                       },
                        'format' => 'raw',
                    ],
                     
                                [
                        'label' => 'No. K/P',
                        'value' => function($model) {
                             if ($model->biodata->NatCd == "MYS") {
                                return $model->ICNO;
                            } else {
                                return $model->biodata->latestPaspot;
                            }
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Tarikh/Masa Mohon',
                        'value' => function($model) {
                            return $model->tarikh_mohon;
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ], 
                    [
                        'label' => 'Tujuan',
                        'value' => function($model) {
                            return $model->tujuan;
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ], 
                                [
                        'label' => 'Jenis Permohonan',
                        'value' => function($model) {
                            if ($model->apply_type == 1) {
                            return '<span class="label label-primary">Individu</span>';
                            }else if ($model->apply_type == 2) {
                             return '<span class="label label-warning">Keluarga</span>';   
                            } 
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                                [
                        'label' => 'Status Permohonan',
                        'value' => function($model) {
                            if ($model->status_semasa == 1) {
                            return '<span class="label label-primary">Diterima</span>';
                            }else if ($model->status_semasa == 2) {
                             return '<span class="label label-success">Lulus</span>';   
                            }else if ($model->status_semasa == 3) {
                                return '<span class="label label-danger">Ditolak</span>';   
                            }
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                   [
                        'label' => 'Surat Pengesahan',
                        'value' => function($model) {
                            if ($model->status_semasa == 2) {
                                return Html::a('<i class="fa fa-download" aria-hidden="true"></i> SURAT', [
                                            'surat-v',
                                            'id' => $model->id
                                                ], [
                                            'class' => 'btn btn-default',
                                            'target' => '_blank',
                                ]);
                            }else{
                                return $model->approved_text;
                            }
                        },
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                        ];



                        echo GridView::widget([
                            'dataProvider' => $permohonan,
                            'columns' => $gridColumns,
                            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                            'beforeHeader' => [
                                [
                                    'columns' => [],
//                                    'options' => ['class' => 'skip-export'] // remove this row from export
                                ]
                            ],
                            'toolbar' => [
//                                '{export}',
//                                '{toggleData}'
                            ],
                            'bordered' => true,
                            'striped' => false,
                            'condensed' => false,
                            'responsive' => true,
                            'hover' => true, 
                            'panel' => [
                                'type' => GridView::TYPE_DEFAULT,
                                'heading' => '<h2>Rekod Permohonan yang Telah Disahkan</h2>',
                            ],
                        ]);
                        ?>
            </div>


        </div>
    </div>  

</div>  

