<?php
 
use kartik\tabs\TabsX;
use yii\helpers\Html;
use kartik\grid\GridView;
 

error_reporting(0);
?>
 
<?php $this->title = 'Pinjaman Peribadi';?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1306,1309,1312], 'vars' => []]); ?>

<div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><?php echo $title;?> [ Pinjaman Peribadi ]</strong></h2>
        <div class="clearfix"></div>
    </div> 
        
    <?php if($title == 'Senarai Menunggu Semakan'){?>
    <div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_content">
            <div class="table-responsive">
             <?= GridView::widget([
        'dataProvider' => $senarai,
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
                        'heading' => '<h2>Status Permohonan Pinjaman Peribadi</h2>',
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn',
                                            'header' => 'Bil',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                                            ],
                        [
                            'label' => 'Nama Pemohon',
                            'value' => 'biodata.CONm',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                        ],
                        
                        [
                            'label' => 'Tarikh Mohon',
                            'value' => 'tarikhm',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                        ],
                    [
                            'header' => 'Status Penyelia BSM',
                            'format' => 'raw',
                            'value' => 'statuspt',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            
                        ],
                   [
                            'header' => 'Status Pegawai BSM',
                            'format' => 'raw',
                            'value' => 'statuss',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            
                        ], 
                    [
                        'label' => 'Tindakan',
                        'format' => 'raw',
                        'headerOptions' => ['class'=>'text-center'],
                                        'contentOptions' => ['class'=>'text-center', 'style' => 'width: 3%;'],
                        'value'=>function ($list){
                                     
                                return Html::a('<i class="fa fa-edit">', ["pinjaman/tindakan-pt-bsm", 'id' => $list->id,  'icno' => $list->icno]); 
                        },
                    ],

                ],
            ]); ?>
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
                        'heading' => '<h2>Status Permohonan Pinjaman Peribadi</h2>',
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn',
                                            'header' => 'Bil',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                                            ],
                        [
                            'label' => 'Nama Pemohon',
                            'value' => 'biodata.CONm',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                        ],
                        
                        [
                            'label' => 'Tarikh Mohon',
                            'value' => 'tarikhm',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                        ],
                    [
                            'header' => 'Status Penyelia BSM',
                            'format' => 'raw',
                            'value' => 'statuspt',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                           
                        ],
                   [
                            'header' => 'Status Pegawai BSM',
                            'format' => 'raw',
                            'value' => 'statuss',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                           
                        ],
                    [
                        'label' => 'Tindakan',
                        'format' => 'raw',
                        'headerOptions' => ['class'=>'text-center'],
                                        'contentOptions' => ['class'=>'text-center', 'style' => 'width: 3%;'],
                        'value'=>function ($list){
                 
                                return Html::a('<i class="fa fa-edit">', ["pinjaman/tindakan-pp-bsm", 'id' => $list->id, 'icno' => $list->icno]);
//                                return Html::a('<i class="fa fa-edit">', ["pinjaman/detail-view-payroll", 'id' => $list->id, 'icno' => $list->icno]);

                                     
                            } 
                    ],

                ],
            ]); ?>
    </div>
        </div>
     
    </div>
</div><?php }?>
                 <br>
                    <ul>
                        <li><span class="label label-warning">Baru</span> : Permohonan Baru</li>
                        <li><span class="label label-primary">Dalam Tindakan PT</span> : Menunggu tindakan dari Pembantu Tadbir BSM</li>
                        <li><span class="label label-info">Dalam Tindakan BSM</span> : Menunggu tindakan dari Pegawai BSM</li>
                        <li><span class="label label-success">Berjaya</span> : Diluluskan</li>
                    </ul>
            </div>
            </div> 
        
    </div>
</div>
</div>


