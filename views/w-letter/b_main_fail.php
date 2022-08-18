<?php

use kartik\grid\GridView;
use yii\helpers\Html;
?> 
<?= $this->render('menu') ?>
<div class="col-md-12 col-sm-12 col-xs-12">
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
                                return $model->biodata->jawatan? $model->biodata->jawatan->fname:'Tiada Maklumat';
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
                        [],
                    ],
                    'bordered' => true,
                    'striped' => false,
                    'condensed' => false,
                    'responsive' => true,
                    'hover' => true,
                    'panel' => [
                        'type' => GridView::TYPE_DEFAULT,
                        'heading' => '<h2>Rekod Permohonan Ditolak KJ</h2>',
                    ],
                ]);
                ?>
            </div>


        </div>
    </div>  

</div>  

