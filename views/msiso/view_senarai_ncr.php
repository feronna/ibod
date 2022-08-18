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
        <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p> 
        <div class="clearfix"></div>
        </div>
          
      
     <div class="col-xs-12 col-md-12 col-lg-12"> 
        
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
                'label' => 'Rujukan Fail',
                'value' => 'rujukan_fail',
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
                'label' => 'Tindakan',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>function ($list){ 
                        return Html::a('<i class="fa fa-eye">', ["msiso/paparan-ncr", 'id' => $list->id]); 
                      },
            ], 
               
        ],
    ]); ?>
        
    </div>
</div>
</div>
</div>
