<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use kartik\select2\Select2;

error_reporting(0);
?> 
<?= $this->render('menu') ?> 
 
<div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
        <h2><i class="fa fa-list"></i><strong> AUDIT REPORT</strong></h2>
        <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p> 
        <div class="clearfix"></div>
        </div>
          
      
     <div class="col-xs-12 col-md-12 col-lg-12"> 
        <!-- senarai ofi -->
             <?= GridView::widget([
                    'dataProvider' => $senarai,
//                    'filterModel' => true,
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
                        'heading' => '<h2>OFI (PELUANG PENAMBAHBAIKAN)</h2>',
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn',
                                            'header' => '#',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                                            ], 
                 
             
           

            [
                'label' => 'JAFPIB',
                'value' => 'dept',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
            ], 
            [
                'label' => 'Klausa',
                'value' => 'clause',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
            ], 

            [
                'label' => 'Tarikh Audit',
                'value' => 'tarikhAudit',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
            ], 
            [
                'label' => ' Tindakan',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>function ($list){ 
                    if($list->status_tindakan == '2' && $list->status == '2'){
                        return Html::a('<i class="fa fa-eye"></i>', ["msiso/paparan-ofi", 'id' => $list->id], ['class' => 'btn btn-primary'])
                        .Html::a('<i class="fa fa-pencil"></i>', ["msiso/kemaskini-ofi", 'id' => $list->id], ['class' => 'btn btn-success'])
                        .Html::a('<i class="fa fa-trash"></i>', ['del-ofi', 'id' => $list->id], ['class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]);
                    }
                    elseif($list->status_tindakan == '2' && $list->status == '1'){
                        return Html::a('<i class="fa fa-eye"></i>', ["msiso/paparan-ofi", 'id' => $list->id], ['class' => 'btn btn-primary'])
                        .Html::a('<i class="fa fa-pencil"></i>', ["msiso/kemaskini-ofi", 'id' => $list->id], ['class' => 'btn btn-success'])
                        .Html::a('<i class="fa fa-trash"></i>', ['del-ofi', 'id' => $list->id], ['class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]); 
                    }
                    elseif($list->status_tindakan == '3'){
                        return Html::a('<i class="fa fa-eye"></i>', ["msiso/paparan-ofi", 'id' => $list->id], ['class' => 'btn btn-primary'])
                        .Html::a('<i class="fa fa-pencil">&nbsp; KEMASKINI</i>', ["msiso/kemaskini-ofi", 'id' => $list->id], ['class' => 'btn btn-danger'])
                        .Html::a('<i class="fa fa-trash"></i>', ['del-ofi', 'id' => $list->id], ['class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]); 
                    } 
                    elseif($list->status_tindakan == '1' || $list->status_tindakan == '4'){ 
                        return Html::a('<i class="fa fa-eye"></i>', ["msiso/paparan-ofi", 'id' => $list->id], ['class' => 'btn btn-primary']);  
                    } 
                    elseif($list->status_tindakan == '5' ){ //process done 
                        return Html::a('<i class="fa fa-eye"></i>', ["msiso/complete-report-ofi", 'id' => $list->id], ['class' => 'btn btn-primary']) 
                        .Html::a('<i class="fa fa-pencil"></i>', ["msiso/kemaskini-ofi", 'id' => $list->id], ['class' => 'btn btn-success']) 
                        .Html::a('<i class="fa fa-trash"></i>', ['del-ofi', 'id' => $list->id], ['class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]); 
                                           
                    } 
                 },
            ], 
               
        ],
    ]); ?>
        
    </div>

    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <!-- senarai ncr -->
             <?= GridView::widget([
                    'dataProvider' => $dataProvider,
//                    'filterModel' => true,
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
                        'heading' => '<h2>NCR (NON-CONFORMITY REPORT)</h2>',
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn',
                                            'header' => '#',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                                            ],  
             
                        [
                            'label' => 'JAFPIB',
                            'value' => 'dept',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                        ], 
                        [
                            'label' => 'Klausa',
                            'value' => 'clause',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                        ], 

                        [
                            'label' => 'Tarikh Audit',
                            'value' => 'tarikhAudit',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                        ],
                        [
                            'label' => 'Auditee',
                            'value' => 'auditee',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                        ], 
                        [
                            'label' => '',
                            'format' => 'raw',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                            // 'value'=>function ($list){ 
                            //         return Html::a('<i class="fa fa-eye"></i>', ["msiso/paparan-ncr", 'id' => $list->id],['class' => 'btn btn-primary'])
                            //         .Html::a('<i class="fa fa-pencil"></i>', ["msiso/kemaskini-ncr", 'id' => $list->id], ['class' => 'btn btn-success']);  
                                    
                            //       },

                            'value'=>function ($list){ 
                                if($list->status_tindakan == '2' && $list->status_semasa == '2'){
                                    return Html::a('<i class="fa fa-eye"></i>', ["msiso/paparan-ncr", 'id' => $list->id], ['class' => 'btn btn-primary'])
                                    .Html::a('<i class="fa fa-pencil"></i>', ["msiso/kemaskini-ncr", 'id' => $list->id], ['class' => 'btn btn-success'])
                                    .Html::a('<i class="fa fa-trash"></i>', ['del-ncr', 'id' => $list->id], ['class' => 'btn btn-danger',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to delete this item?',
                                            'method' => 'post',
                                        ],
                                    ]);
                                }
                                elseif($list->status_tindakan == '2' && $list->status_semasa == '1'){
                                    return Html::a('<i class="fa fa-eye"></i>', ["msiso/paparan-ncr", 'id' => $list->id], ['class' => 'btn btn-primary'])
                                    .Html::a('<i class="fa fa-pencil"></i>', ["msiso/kemaskini-ncr", 'id' => $list->id], ['class' => 'btn btn-success']) 
                                    .Html::a('<i class="fa fa-trash"></i>', ['del-ncr', 'id' => $list->id], ['class' => 'btn btn-danger',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to delete this item?',
                                            'method' => 'post',
                                        ],
                                    ]); 
                                }
                                elseif($list->status_tindakan == '3'){
                                    return Html::a('<i class="fa fa-eye"></i>', ["msiso/paparan-ncr", 'id' => $list->id], ['class' => 'btn btn-primary'])
                                    .Html::a('<i class="fa fa-pencil"></i>&nbsp;KEMASKINI', ["msiso/kemaskini-ncr", 'id' => $list->id], ['class' => 'btn btn-danger'])
                                    .Html::a('<i class="fa fa-trash"></i>', ['del-ncr', 'id' => $list->id], ['class' => 'btn btn-danger',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to delete this item?',
                                            'method' => 'post',
                                        ],
                                    ]); 
                                } 
                                elseif($list->status_tindakan == '7'){ 
                                    return Html::a('<i class="fa fa-eye"></i>', ["msiso/paparan-ncr", 'id' => $list->id], ['class' => 'btn btn-primary']) 
                                    .Html::a('<i class="fa fa-pencil"></i>', ["msiso/kemaskini-ncr", 'id' => $list->id], ['class' => 'btn btn-success'])  
                                    .Html::a('<i class="fa fa-trash"></i>', ['del-ncr', 'id' => $list->id], ['class' => 'btn btn-danger',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this item?',
                                        'method' => 'post',
                                    ],
                                ]);        
                                } 
                                elseif($list->status_tindakan == '6'){ 
                                    return Html::a('<i class="fa fa-eye"></i>', ["msiso/paparan-ncr", 'id' => $list->id], ['class' => 'btn btn-primary']);       
                                } 
                                elseif($list->status_tindakan == '1' || $list->status_tindakan == '4'  ){ 
                                    return Html::a('<i class="fa fa-eye"></i>', ["msiso/paparan-ncr", 'id' => $list->id], ['class' => 'btn btn-primary']);       
                                } 
                                elseif($list->status_tindakan == '5' ){ //process done 
                                    return Html::a('<i class="fa fa-eye"></i>', ["msiso/paparan-ncr", 'id' => $list->id], ['class' => 'btn btn-primary'])
                                    .Html::a('<i class="fa fa-pencil"></i>&nbsp;VERIFIKASI', ["msiso/kemaskini-ncr", 'id' => $list->id], ['class' => 'btn btn-success']);                     
                                } 
                            },
                        ], 
               
        ],
    ]); ?>
        
    </div> 
      <!-- // senarai nota audit -->
     <div class="col-xs-12 col-md-12 col-lg-12"> 
        
             <?= GridView::widget([
                    'dataProvider' => $list,
//                    'filterModel' => true,
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
                        'heading' => '<h2> NOTA AUDIT </h2>',
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn',
                                            'header' => '#',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                                            ], 
                  
                    [
                        'label' => 'JAFPIB',
                        'value' => 'dept',
                        'headerOptions' => ['class'=>'text-center'],
                                        'contentOptions' => ['class'=>'text-center'],
                    ], 

                    [
                        'label' => 'Tarikh Audit',
                        'value' => 'tarikhAudit',
                        'headerOptions' => ['class'=>'text-center'],
                                        'contentOptions' => ['class'=>'text-center'],
                    ], 
                    [
                        'label' => ' ',
                        'format' => 'raw',
                        'headerOptions' => ['class'=>'text-center'],
                        'contentOptions' => ['class'=>'text-center'],
                        'value'=>function ($list){ 
                            return
                             Html::a('<i class="fa fa-pencil"></i>', ["msiso/kemaskini-nota-audit", 'id' => $list->id], ['class' => 'btn btn-success'])                         
                            .Html::a('<i class="fa fa-download"> NOTA AUDIT</i> ', Yii::$app->FileManager->DisplayFile($list->attachment), ['class'=>'btn btn-primary', 'target' => '_blank'])  
                            .Html::a(' <i class="fa fa-trash"></i>', ['del-nota-audit', 'id' => $list->id], ['class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]); 
                            // return Html::a('<i class="fa fa-eye"></i>', ["msiso/paparan-nota-audit", 'id' => $list->id],['class' => 'btn btn-primary']);
                            // .Html::a('<i class="fa fa-pencil"></i>', ["msiso/kemaskini-nota-audit", 'id' => $list->id], ['class' => 'btn btn-success']);  
                            
                            },
                    ], 
                        
                ],
            ]); ?>
                
    </div>

    <!-- senarai best practice -->
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        
        <?= GridView::widget([
               'dataProvider' => $practice, 
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
                   'heading' => '<h2> AMALAN BAIK </h2>',
               ],
               'columns' => [
                   ['class' => 'yii\grid\SerialColumn',
                                       'header' => '#',
                       'headerOptions' => ['class'=>'text-center'],
                                       'contentOptions' => ['class'=>'text-center'],
                                       ],  
                    [
                        'label' => 'JAFPIB',
                        'value' => 'dept',
                        'headerOptions' => ['class'=>'text-center'],
                                        'contentOptions' => ['class'=>'text-center'],
                    ], 
 
                    [
                        'label' => '',
                        'format' => 'raw',
                        'headerOptions' => ['class'=>'text-center'],
                                        'contentOptions' => ['class'=>'text-center'],
                        'value'=>function ($list){  
                                return Html::a('<i class="fa fa-eye"></i>', ["msiso/paparan-best-practice", 'id' => $list->id],['class' => 'btn btn-primary'])
                                .Html::a('<i class="fa fa-pencil"></i>', ["msiso/kemaskini-best-practice", 'id' => $list->id], ['class' => 'btn btn-success'])
                                .Html::a('<i class="fa fa-trash"></i>', ['del-best-practice', 'id' => $list->id], ['class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]);   
                                
                              },
                    ], 
                        
                ],
                ]); ?>
   
            </div>
</div>
</div>
</div>
