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
                            return ucwords(strtolower($model->biodata->CONm));
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Jawatan',
                        'value' => function($model) {
                            return $model->biodata->jawatan ? $model->biodata->jawatan->fname : 'Tiada Maklumat';
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
                        'label' => 'Tarikh Mula',
                        'value' => function($model) {
                            return $model->biodata->getTarikh($model->StartDate);
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Tarikh Tamat',
                        'value' => function($model) {
                            return $model->biodata->getTarikh($model->EndDate);
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Senarai Tugas',
                        'value' => function($model) {
                            return $model->tugas;
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center', 'width' => '200px'],
                    ],
                    [
                        'label' => 'JFPIU',
                        'value' => function($model) {
                            return $model->biodata->department->shortname;
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Kampus',
                        'value' => function($model) {
                            return $model->biodata->kampus->campus_name;
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Nama KJ',
                        'value' => function($model) {
                            return $model->biodata->department->k_jabatan->CONm;
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Status Permohonan Kj',
                        'value' => function($model) {
                            if ($model->approved_kj_status == 1) {
                                return '<span class="label label-success">Lulus</span>';
                            } else if ($model->approved_kj_status == 2) {
                                return '<span class="label label-danger">Ditolak</span>';
                            } else {
                                return '<span class="label label-danger">Menunggu Perakuan</span>';
                            }
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Status Permohonan BSM',
                        'value' => function($model) {
                            if ($model->approved_bsm_status == 1) {
                                return '<span class="label label-success">Lulus</span>';
                            } else if ($model->approved_bsm_status == 2) {
                                return '<span class="label label-danger">Ditolak</span>';
                            } else {
                                return '<span class="label label-danger">Menunggu Perakuan</span>';
                            }
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Surat Kebenaran',
                        'value' => function($model) {
                            if ($model->status_semasa == 3) {
                                return Html::a('<i class="fa fa-download" aria-hidden="true"></i> SURAT', [
                                            'surat-w',
                                            'title' => 'Baru',
                                            'id' => $model->id
                                                ], [
                                            'class' => 'btn btn-default',
                                            'target' => '_blank',
                                ]);
                            } else if ($model->status_semasa == 4) {
                                return '<b>Ulasan</b>: ' . $model->approved_kj_ulasan . '<br/><b>Ulasan</b>: ' . $model->approved_bsm_ulasan;
                            } else {
                                return '<span class="label label-danger">Menunggu Perakuan</span>';
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
                                'heading' => '<h2>Rekod Permohonan yang Telah Disahkan</h2>',
                            ],
                        ]);
                        ?>
            </div>


        </div>
    </div>  

</div>  

