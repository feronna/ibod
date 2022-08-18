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
                        'label' => 'Butiran Permohonan',
                        'value' => function($model) {
                            if ($model->biodata->NatCd == "MYS") {
                                $icno = $model->ICNO;
                            } else {
                                $icno = $model->biodata->latestPaspot;
                            }
                            return 'Nama : ' . ucwords(strtolower($model->biodata->CONm)) . '<br/>No. K/P : ' . $icno;
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
                                'heading' => '<h2>Status Pengesahan Kakitangan UMS</h2>',
                            ],
                        ]);
                        ?>
                    </div>
 
                </div>
            </div>  

</div>  

