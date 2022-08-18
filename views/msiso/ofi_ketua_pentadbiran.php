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
        <h2><i class="fa fa-list"></i><strong> OFI AUDIT REPORT</strong></h2>
        <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p> 
        <div class="clearfix"></div>
        </div>
          
    <?php if($kp){?>  
     <div class="col-xs-12 col-md-12 col-lg-12"> 
        <!-- view KP departmen -->
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
                        'heading' => '<h2>Opportunities for Improvement (OFI)</h2>',
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
                        'label' => 'Auditor',
                        'value' => 'auditor_name',
                        'headerOptions' => ['class'=>'text-center'],
                                        'contentOptions' => ['class'=>'text-center'],
                    ], 
                    [
                        'label' => ' ',
                        'format' => 'raw',
                        'headerOptions' => ['class'=>'text-center'],
                                        'contentOptions' => ['class'=>'text-center'],
                        'value'=>function ($list){ 
                            if($list->status_tindakan == '4'){
                                return Html::a('<i class="fa fa-pencil"></i>', ["msiso/tindakan-auditee-dept", 'id' => $list->id], ['class' => 'btn btn-success']); 
                            }elseif($list->status_tindakan == '1'){
                                return Html::a('<i class="fa fa-eye"></i>', ["msiso/paparan-ofi-jabatan", 'id' => $list->id], ['class' => 'btn btn-primary']);
                                // .Html::a('<i class="fa fa-download"></i>', ["msiso/tindakan-auditee-dept", 'id' => $list->id], ['class' => 'btn btn-success']); 

                            }
                        },
                    ], 
                        
                ],
            ]); ?>
        
    </div> 
    <?php }?>
    <?php if($tempKP){?>  

    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <!-- view KP temp access -->
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
                        'heading' => '<h2>Opportunities for Improvement (OFI)</h2>',
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
                        'label' => 'Auditor',
                        'value' => 'auditor_name',
                        'headerOptions' => ['class'=>'text-center'],
                                        'contentOptions' => ['class'=>'text-center'],
                    ], 
                    [
                        'label' => ' ',
                        'format' => 'raw',
                        'headerOptions' => ['class'=>'text-center'],
                                        'contentOptions' => ['class'=>'text-center'],
                        'value'=>function ($list){ 
                            if($list->status_tindakan == '4'){
                                return Html::a('<i class="fa fa-pencil"></i>', ["msiso/tindakan-auditee-dept", 'id' => $list->id], ['class' => 'btn btn-success']); 
                            }elseif($list->status_tindakan == '1'){
                                return Html::a('<i class="fa fa-eye"></i>', ["msiso/paparan-ofi-jabatan", 'id' => $list->id], ['class' => 'btn btn-primary']);
                                // .Html::a('<i class="fa fa-download"></i>', ["msiso/tindakan-auditee-dept", 'id' => $list->id], ['class' => 'btn btn-success']); 

                            }
                        },
                    ], 
                        
                ],
            ]); ?>
        
    </div> 
    <?php }?>


</div>
</div>
</div>
