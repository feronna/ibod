<?php

use kartik\grid\GridView;
use yii\helpers\Html;
?> 
<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/keterhutangan/_menu');?>
</div>
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
                        'label' => 'Sebab/Alasan',
                        'value' => function($model) {
                              if($model->tarikh_hantar == null){
                                return '<span class="label label-danger">Tiada Tindakan</span>'; 
                            }else{
                                return $model->reason;
                            }
          
                        },
                        'format' => 'raw',
                    ],
                                
                    [
                        'label' => 'Tarikh Hantar Sebab/Alasan',
                        'value' => function($model) {
                            if($model->tarikh_hantar == null){
                                return '<span class="label label-danger">Tiada Tindakan</span>'; 
                            }else{
                                return $model->tarikh_hantar;
                            }
          
                        },
                        'format' => 'raw',
                    ],
                       
                                
                    [
                            'label'=>'Surat',
                            'format' => 'raw',
                            'value'=>function ($data){
                       
                        //      return  Html::button('<i class="fa fa-info" aria-hidden="true"></i> INFO', ['value' => \yii\helpers\Url::to(['keterhutangan/detail-view', 'id' => $data->sm_ic_no]), 'class' => 'mapBtn btn-sm btn-danger btn-block']);
                             return Html::a('<i class="fa fa-download">', ["keterhutangan/laporan-pemakluman-kedudukan-kewangan-kakitangan", 'id' => $data->id, 'icno' => $data->icno]);                   
                          // \yii\helpers\Html::a('pemaklumanketuajabatan.pdf', ['keterhutangan/laporan-pemakluman-kedudukan-kewangan-kakitangan', 'id' => $item->id], [ 'target' => '_blank']) 
                            },
                                    
                                    
                              'hAlign' => 'center',
                              'vAlign' => 'middle',
                        ],
                
                                
                    [
                            'label'=>'Lihat',
                            'format' => 'raw',
                            'value'=>function ($data){
                       
                          //   return  Html::button('<i class="fa fa-info" aria-hidden="true"></i> INFO', ['value' => \yii\helpers\Url::to(['keterhutangan/detail-view', 'id' => $data->icno]), 'class' => 'mapBtn btn-sm btn-danger btn-block']);
                             return Html::a('<i class="fa fa-eye">', ["keterhutangan/detail-view-kj", 'id' => $data->icno]);                   

                            },
                                    
                                    
                              'hAlign' => 'center',
                              'vAlign' => 'middle',
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
                                'heading' => '<h2>Senarai Kakitangan Menghadapi Keterhutangan Kewangan Serius</h2>',
                            ],
                        ]);
                        ?>
            </div>


        </div>
    </div>  

</div>  

