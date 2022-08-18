<?php

use yii\helpers\Html;
use kartik\grid\GridView;

 
error_reporting(0);
?>
<?php if($title == 'Senarai Menunggu Semakan'){?>
<div class="row"> 
     <div class="col-xs-12 col-md-12 col-lg-12"> 
    
        
        <div class="x_content">
            <div class="table-responsive">
             <?= GridView::widget([
                    'dataProvider' => $senarai,
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
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
                    'beforeHeader' => [
                    [
                        'columns' => [
                            ['content' => 'ELAUN PAKAIAN PANAS', 'options' => ['colspan' => 9, 'class' => 'text-center ',
                                'style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                              
                            ],
                        ],
                    ]
                ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn',
                                            'header' => '#',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                                            ],
                         [
                'label' => 'Nama Pemohon',
                'value' => 'kakitangan.CONm',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center', 'style' => 'width: 15%;'],
            ],
            
            [
                'label' => 'Tarikh Mohon',
                'value' => 'entrydate',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center', 'style' => 'width: 10%;'],
            ],
            [
                'label' => 'Status Penyelia BSM',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center', 'style' => 'width: 10%;'],
                'value'=>'statusLabel',
            ],
            [
                'label' => 'Status Pegawai BSM',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center', 'style' => 'width: 10%;'],
                'value'=>'statuspp',
            ],
            [
                'label' => 'Status Ketua BSM',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center', 'style' => 'width: 10%;'],
                'value'=>'statuskj',
            ], 
               [
                'label' => 'Dokumen Sokongan',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-left'],
                
               'value'=>function ($list){ 
                    if($list->dokumen_sokongan == NULL){
                    return Html::a(' DOKUMEN KELULUSAN', Yii::$app->FileManager->DisplayFile($list->dokumen_sokongan2), ['class'=>'fa fa-download', 'target' => '_blank']);
 
                    }else{
                    return  Html::a(' LN 1', Yii::$app->FileManager->DisplayFile($list->dokumen_sokongan), ['class'=>'fa fa-download', 'target' => '_blank'])
                    .Html::a(' DOKUMEN KELULUSAN', Yii::$app->FileManager->DisplayFile($list->dokumen_sokongan2), ['class'=>'fa fa-download', 'target' => '_blank']);
                        
                    }
                }
            ], 
           [
                'label' => 'Salinan Surat',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-left'],
                
               'value'=>function ($list){
                            if($list->isActive2 == '1' ){
                        return  Html::a(' SURAT KELULUSAN', ['borang/sk_lulus', 'id' => $list->id], ['class'=>'fa fa-download', 'target' => '_blank']).'<br>'
                                    .Html::a(' MEMO', ['borang/memo', 'id' => $list->id], ['class'=>'fa fa-download', 'target' => '_blank']).'<br>'
                                    .Html::a(' KELULUSAN KETUA BSM', ['borang/surat_kj', 'id' => $list->id], ['class'=>'fa fa-download', 'target' => '_blank']);
                            } 
                      },
            ], 
             [
                'label' => 'Tindakan',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center', 'style' => 'width: 3%;'],
                'value'=>function ($list){
                            if($list->status_kj == 'MENUNGGU TINDAKAN'   ){
                        return  
                        Html::a('<i class="fa fa-edit">', ["borang/semakan_bsm", 'id' => $list->id]);
                            }
                            else{
                        return Html::a('<i class="fa fa-edit">', ["borang/semakan_bsm", 'id' => $list->id]);
                            }
                        
                      },
            ], 
 

            ],
        ]); ?>
                
             
    </div>
        </div>
    
    </div>
</div><?php }?>

<?php if($title == 'Senarai Menunggu Perakuan'){?>
<div class="row"> 
     <div class="col-xs-12 col-md-12 col-lg-12"> 
    
        <div class="x_content">
            <div class="table-responsive">
             <?= GridView::widget([
                    'dataProvider' => $senarai,
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
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
                      'beforeHeader' => [
                    [
                        'columns' => [
                            ['content' => 'ELAUN PAKAIAN PANAS', 'options' => ['colspan' => 9, 'class' => 'text-center ',
                                'style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                              
                            ],
                        ],
                    ]
                ],
            'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                                'header' => 'Bil',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                                ],
             [
                'label' => 'Nama Pemohon',
                'value' => 'kakitangan.CONm',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center', 'style' => 'width: 15%;'],
            ],
            
            [
                'label' => 'Tarikh Mohon',
                'value' => 'entrydate',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center', 'style' => 'width: 10%;'],
            ],
            [
                'label' => 'Status Penyelia BSM',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center', 'style' => 'width: 10%;'],
                'value'=>'statusLabel',
            ],
            [
                'label' => 'Status Pegawai BSM',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center', 'style' => 'width: 10%;'],
                'value'=>'statuspp',
            ],
            [
                'label' => 'Status Ketua BSM',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center', 'style' => 'width: 10%;'],
                'value'=>'statuskj',
            ], 
               [
                'label' => 'Dokumen Sokongan',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                'contentOptions' => ['class'=>'text-left'],
                'value'=>function ($list){ 
                    if($list->dokumen_sokongan == NULL){
                    return Html::a(' DOKUMEN KELULUSAN', Yii::$app->FileManager->DisplayFile($list->dokumen_sokongan2), ['class'=>'fa fa-download', 'target' => '_blank']);
    
                    }else{
                    return  Html::a(' LN 1', Yii::$app->FileManager->DisplayFile($list->dokumen_sokongan), ['class'=>'fa fa-download', 'target' => '_blank'])
                    .Html::a(' DOKUMEN KELULUSAN', Yii::$app->FileManager->DisplayFile($list->dokumen_sokongan2), ['class'=>'fa fa-download', 'target' => '_blank']);
                    
                    }
                } 
            ], 
           [
                'label' => 'Salinan Surat',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-left'],
                
               'value'=>function ($list){
                            if($list->isActive2 == '1' ){
                        return  Html::a(' SURAT KELULUSAN', ['borang/sk_lulus', 'id' => $list->id], ['class'=>'fa fa-download', 'target' => '_blank']).'<br>'
                                    .Html::a(' MEMO', ['borang/memo', 'id' => $list->id], ['class'=>'fa fa-download', 'target' => '_blank']).'<br>'
                                    .Html::a(' KELULUSAN KETUA BSM', ['borang/surat_kj', 'id' => $list->id], ['class'=>'fa fa-download', 'target' => '_blank']);
                            } 
                      },
            ], 
              
            [
                'label' => 'Tindakan',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center', 'style' => 'width: 3%;'],
                'value'=>function ($list){
                            if($list->status_pp === 'MENUNGGU KELULUSAN'){
                        return  
                        Html::a('<i class="fa fa-edit">', ["borang/tindakan_bsm", 'id' => $list->id]);
                            }
                            else{
                        return Html::a('<i class="fa fa-edit">', ["borang/tindakan_bsm", 'id' => $list->id]);
                            }
                        
                      },
            ],
            
        ],
    ]); ?>
    </div>
        </div>
     
    </div>
</div><?php }?>
 <?php if($title == 'Senarai Menunggu Kelulusan'){?>
<div class="row"> 
     <div class="col-xs-12 col-md-12 col-lg-12"> 
    
        <div class="x_content">
            <div class="table-responsive">
            <?= GridView::widget([
                    'dataProvider' => $senarai,
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
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
                    'beforeHeader' => [
                    [
                        'columns' => [
                            ['content' => 'ELAUN PAKAIAN PANAS', 'options' => ['colspan' => 9, 'class' => 'text-center ',
                                'style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                              
                            ],
                        ],
                    ]
                ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn',
                                            'header' => '#',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                                            ],
                         [
                'label' => 'Nama Pemohon',
                'value' => 'kakitangan.CONm',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center', 'style' => 'width: 15%;'],
            ],
            
            [
                'label' => 'Tarikh Mohon',
                'value' => 'entrydate',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center', 'style' => 'width: 10%;'],
            ],
            [
                'label' => 'Status Penyelia BSM',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center', 'style' => 'width: 10%;'],
                'value'=>'statusLabel',
            ],
            [
                'label' => 'Status Pegawai BSM',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center', 'style' => 'width: 10%;'],
                'value'=>'statuspp',
            ],
            [
                'label' => 'Status Ketua BSM',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center', 'style' => 'width: 10%;'],
                'value'=>'statuskj',
            ], 
               [
                'label' => 'Dokumen Sokongan',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                'contentOptions' => ['class'=>'text-left'], 
                'value'=>function ($list){ 
                    if($list->dokumen_sokongan == NULL){
                    return Html::a(' DOKUMEN KELULUSAN', Yii::$app->FileManager->DisplayFile($list->dokumen_sokongan2), ['class'=>'fa fa-download', 'target' => '_blank']);
    
                    }else{
                    return  Html::a(' LN 1', Yii::$app->FileManager->DisplayFile($list->dokumen_sokongan), ['class'=>'fa fa-download', 'target' => '_blank'])
                    .Html::a(' DOKUMEN KELULUSAN', Yii::$app->FileManager->DisplayFile($list->dokumen_sokongan2), ['class'=>'fa fa-download', 'target' => '_blank']);
                    
                    }
                } 
            ], 
           [
                'label' => 'Salinan Surat',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-left'],
                
               'value'=>function ($list){
                            if($list->isActive2 == '1' ){
                        return  Html::a(' SURAT KELULUSAN', ['borang/sk_lulus', 'id' => $list->id], ['class'=>'fa fa-download', 'target' => '_blank']).'<br>'
                                    .Html::a(' MEMO', ['borang/memo', 'id' => $list->id], ['class'=>'fa fa-download', 'target' => '_blank']).'<br>'
                                    .Html::a(' KELULUSAN KETUA BSM', ['borang/surat_kj', 'id' => $list->id], ['class'=>'fa fa-download', 'target' => '_blank']);
                            } 
                      },
            ], 
            [
                'label' => 'Tindakan',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center', 'style' => 'width: 3%;'],
                'value'=>function ($list){
                            if($list->status_kj == 'MENUNGGU TINDAKAN'   ){
                        return  
                        Html::a('<i class="fa fa-edit">', ["borang/tindakan_kj", 'id' => $list->id]);
                            }
                            else{
                        return Html::a('<i class="fa fa-edit">', ["borang/tindakan_kj", 'id' => $list->id]);
                            }
                        
                      },
            ],
 

            ],
        ]); ?>
    </div>
        </div>
     
    </div>
</div><?php }?>