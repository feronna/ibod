<?php

use kartik\grid\GridView;
use yii\helpers\Html;
?> 

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
                            return ucwords(strtolower($model->biodata->jawatan->nama));
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'JFPIU',
                        'value' => function($model) {
                            return ucwords(strtolower($model->biodata->department->fullname));
                        },
                        'format' => 'raw',
                    ],
                      [
                        'label' => 'Status Perakuan KP',
                        'value' => function($model) {
                            
                            if($model->kp != null){
                            if ($model->kp_agree == null){
                             return '<span class="label label-danger">BELUM DIPERAKUKAN</span>';
                           
                            }if ($model->kp_agree == 1){
                             return '<span class="label label-success">DERAKUKAN</span>';
                           
                            } if ($model->kp_agree == 2){
                             return '<span class="label label-danger">DiTOLAK</span>';
                           
                            }
                         }else{
                             return 'Terus kepada Pegawai Pelulus';
                         }
                       
                        },
                        'format' => 'raw',
                    ],
                         [
                        'label' => 'Perakuan KP',
                        'value' => function($model) {
                           if($model->kp != null){
                            if ($model->kp_agree == null){
                             return '<span class="label label-danger">BELUM DIPERAKUKAN</span>';
                           
                            }else{
                             return $model->perakuan_kp;
                            }
                           }else{
                                 return 'Terus kepada Pegawai Pelulus'; 
                           }
                       
                        },
                        'format' => 'raw',
                    ],
                                
                          [
                        'label' => 'Status Kelulusan KJ',
                        'value' => function($model) {
                            if ($model->kj_agree == null){
                             return '<span class="label label-danger">BELUM DILULUSKAN</span>';
                           
                            }if ($model->kj_agree == 1){
                             return '<span class="label label-success">DILULUSKAN</span>';
                           
                            } if ($model->kj_agree == 2){
                             return '<span class="label label-danger">DITOLAK</span>';
                           
                            }
                       
                        },
                        'format' => 'raw',
                    ],
                                
                         [
                        'label' => 'Kelulusan KJ',
                        'value' => function($model) {
                            if ($model->kj_agree == null){
                             return '<span class="label label-danger">BELUM DILULUSKAN</span>';
                           
                            }else{
                             return $model->perakuan_kj;
                            }
                       
                        },
                        'format' => 'raw',
                    ],
                                
                    [
                            'label'=>'Deskripsi Tugas',
                            'format' => 'raw',
                            'value'=>function ($data){
                       
                            //  return  Html::button('<i class="fa fa-info" aria-hidden="true"></i> INFO', ['value' => \yii\helpers\Url::to(['keterangan-log', 'id' => $data->id]), 'class' => 'mapBtn btn-sm btn-danger btn-block']);
                                  return Html::a('<i class="fa fa-eye">', ["my-portfolio/deskripsi-tugas-admin", 'id' => $data->id]);                   

                            },
                              'hAlign' => 'center',
                              'vAlign' => 'middle',
                    ],           
                  
                    [
                        'label' => 'Tindakan',
                        'value' => function($model) {
                            return Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', [
                                        'sahkan-kj',
                                        'id' => $model->id,
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
                                    'columns' => [],
                                    'options' => ['class' => 'skip-export'] // remove this row from export
                                ]
                            ],
                            'toolbar' => [
                                [
                                 
                                ],
                            ],
                            'bordered' => true,
                            'striped' => false,
                            'condensed' => false,
                            'responsive' => true,
                            'hover' => true,
                            'panel' => [
                                'type' => GridView::TYPE_DEFAULT,
                                'heading' => '<h2>Senarai Deskripsi Tugas Pegawai</h2>',
                            ],
                        ]);
                        ?>
            </div>


        </div>
    </div>  

</div>  

