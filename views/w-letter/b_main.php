<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm; 
?> 
<?= $this->render('menu') ?>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel"> 
        <div class="x_content">  

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
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
                        'label' => 'Kekangan & Ulasan',
                        'value' => function($model) {
                            if ($model->veh_status) {
                                return '<span class="label label-danger">'.$model->kekangan->name.'</span><br/><br/>Ulasan: '.$model->veh_ulasan;
                            } else{
                                return '-';
                            }
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center', 'width' => '200px'],
                    ],
                    [
                        'label' => 'Dokumen',
                        'value' => function($model) {
                            if ($model->veh_status) {
                                if (!empty($model->veh_file) && $model->veh_file != 'deleted') {
                                    return html::a(Yii::$app->FileManager->NameFile($model->veh_file), Yii::$app->FileManager->DisplayFile($model->veh_file),[
                                        'class' => 'btn btn-default btn-sm','target' => '_blank',
                            ]);
                                }
                                return 'File not exist!';
                            }else{
                                return '-';
                            }
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
                        'label' => 'Status Peraku Kj',
                        'value' => function($model) {
                            if ($model->approved_kj_status == 1) {
                                return '<span class="label label-success">Lulus</span>';
                            } else if ($model->approved_kj_status == 2) {
                                return '<span class="label label-danger">Ditolak</span>';
                            }
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Ulasan Kj',
                        'value' => function($model) {
                            return $model->approved_kj_ulasan;
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center', 'width' => '200px'],
                    ],
                    [
                        'label' => 'Pengesahan Kj',
                        'value' => function($model) {
                            return $model->approved_kj_at;
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center', 'width' => '200px'],
                    ],
                    [
                        'label' => 'Tindakan',
                        'value' => function($model) {
                            return Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', [
                                        'sahkan-bsm',
                                        'id' => $model->id,
                                            ], [
                                        'class' => 'btn btn-default btn-sm',
                            ]);
                        },
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'class' => 'yii\grid\CheckboxColumn',
                                'checkboxOptions' => function ($data) {
                                    return ['value' => $data->id];
                                }
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
                                        [
                                            'content' => Html::a('Sahkan Semua', ['sahkan-semua-bsm'], ['class' => 'btn btn-default btn-sm']),
                                        ],
                                    ],
                                    'bordered' => true,
                                    'striped' => false,
                                    'condensed' => false,
                                    'responsive' => true,
                                    'hover' => true,
                                    'panel' => [
                                        'type' => GridView::TYPE_DEFAULT,
                                        'heading' => '<h2>Rekod Permohonan Semasa</h2>',
                                    ],
                                ]);
                                ?>
                                <div class="col-md-12 col-sm-12 col-xs-12" align="right">  
                                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                                </div>
                                <?php ActiveForm::end(); ?>
            </div>
        </div>


    </div>
</div>  

</div>  

