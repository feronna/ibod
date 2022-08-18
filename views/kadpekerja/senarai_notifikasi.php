<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

error_reporting(0);
?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1319,1322,1324,1326], 'vars' => []]); ?>
 
        
        
<div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><?php echo $title;?></strong></h2> 
            <div class="clearfix"></div>
        </div>
          
      
     <div class="col-xs-12 col-md-12 col-lg-12"> 
        
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
                        'heading' => '<h2>Semakan Permohonan</h2>',
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn',
                                            'header' => '#',
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
                'value' => 'entrydt',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
            ],
            [
                'label' => 'Payment',
                'value' => '',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
            ],
            [
                'label' => 'Pegawai KP',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>'verstatus',
            ],
            [
                'label' => 'Ketua Seksyen',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>'appstatus',
            ],
            
            [
                        'label'=>'Notifikasi',
                        'format' => 'raw',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'value'=>function ($list) { 
                        if($list->status_kad == 0){
                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['notify', 'id' => $list->id]),'style'=>'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-edit mapBtn']);
                        }if($list->status_kad == 1){
                             return $list->statuskad; 
                        }
                        },
                    ],
              
        ],
    ]); ?>
        
    </div>
        
        <div class="x_content"> 
        <ul>
            <li><span class="label label-warning">Pending Payment</span> : Status pembayaran belum lengkap.</li>
            <li><span class="label label-success">Menunggu Kutipan</span> : Permohonan berjaya dan sila kutip Kad Pekerja dikaunter keselamatan.</li>
             
        </ul>
        </div> 
  
    </div>
</div></div>
