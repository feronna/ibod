<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\date\DatePicker;
?> 
<?= $this->render('menu') ?>
<div class="col-md-12 col-sm-12 col-xs-12">

    <div class="x_panel"> 
        <div class="x_content">
            <?php $form = ActiveForm::begin(); ?>

            <div class="col-md-3 col-sm-3 col-xs-3 col-md-offset-8 col-sm-offset-8 col-xs-offset-8">
                <?=
                $form->field($search, 'y_m')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Pilih Tahun & Bulan'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'startView' => 'year',
                        'minViewMode' => 'months',
                        'format' => 'mm-yyyy'
                    ]
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
                        'label' => 'Nama Pemohon',
                        'value' => function($model) {
                            return ucwords(strtolower($model->gl_nama));                       },
                        'format' => 'raw',
                    ],
                                [
                        'label' => 'No. K/P',
                        'value' => function($model) {
                            if ($model->biodata->NatCd == "MYS") {
                                return $model->gl_ICNO;
                            } else {
                                return $model->biodata->latestPaspot;
                            }
                        },
                        'format' => 'raw',
                    ],
                                [
                        'label' => 'Hubungan',
                        'value' => function($model) {
                            return $model->gl_hubungan;
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Kelas Wad',
                        'value' => function($model) {
                            return ucwords(strtolower($model->kelasWad->nama));
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
                        'label' => 'Surat Jaminan',
                        'value' => function($model) {
                            if ($model->status_semasa == 2) {
                                return Html::a('<i class="fa fa-download" aria-hidden="true"></i>', [
                                            'surat-jaminan',
                                            'id' => $model->id,
                                                ], [
                                            'class' => 'btn btn-default',
                                            'target' => '_blank',
                                ]);
                            } else {
                                return '';
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
                                'heading' => '<h2>Laporan (eGL)</h2>',
                            ],
                        ]);
                        ?>
            </div>


        </div>
    </div>  

</div>  

