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
                                'contentOptions' => ['class' => 'text-center','width' => '200px'],
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
                        'label' => 'Tindakan',
                        'value' => function($model) {
                            return Html::a('<i class="fa fa-check" aria-hidden="true"></i>', [
                                            'sahkan',
                                            'id' => $model->id,'action' => 2,
                                                ], [
                                            'class' => 'btn btn-default btn-sm', 
                                ]).Html::a('<i class="fa fa-times" aria-hidden="true"></i>', [
                                            'sahkan',
                                            'id' => $model->id,'action' => 3,
                                                ], [
                                            'class' => 'btn btn-default btn-sm', 
                                ]);
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
                                    'columns' => [ ],
                                    'options' => ['class' => 'skip-export'] // remove this row from export
                                ]
                            ],
                            'toolbar' => [ 
                                [
                                                    'content' => Html::a('Sahkan Semua', ['sahkan-semua'], ['class' => 'btn btn-default btn-sm']),
                                                ],
                            ], 
                            'bordered' => true,
                            'striped' => false,
                            'condensed' => false,
                            'responsive' => true,
                            'hover' => true,  
                            'panel' => [
                                'type' => GridView::TYPE_DEFAULT,
                                'heading' => '<h2>Rekod Permohonan</h2>',
                            ],
                        ]);
                        ?>
            </div>


        </div>
    </div>  

</div>  

