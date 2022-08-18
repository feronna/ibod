<?php
 
use kartik\tabs\TabsX;
use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\hronline\Negara;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
 

error_reporting(0);
?>
 
<?php $this->title = 'Pinjaman Peribadi';?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1306,1309,1312], 'vars' => []]); ?>

<div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><?php echo $title;?>  Pinjaman Peribadi </strong></h2>
        <div class="clearfix"></div>
    </div> 
        
    <?php if($title == 'Status Surat'){?>
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
//                        [
//                                    'label' => 'KP / PASPORT',
//                                    'headerOptions' => ['class'=>'text-center col-md-1'],
//                                    'contentOptions' => ['class'=>'text-center'],
//                                    'value' => function($senarai) {
//                                        return $senarai->biodata->COOldID;
//                                    },
//                                    'format' => 'html',
//                                ],

                    
                    [
                        'label' => 'Jana Surat',
                        'format' => 'raw',  
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'attribute'=>function ($data) {
                            if($data->status_pp == 'DIPERAKUI'){
                                return Html::a('', ['pinjaman/pengesahan', 'id' => $data->id, 'icno' => $data->icno, 'umsper' => $data->biodata->COOldID], ['class'=>'fa fa-download', 'target' => '_blank']).'<br>'
                                        .Html::a('', ['pinjaman/pengesahan2', 'id' => $data->id, 'icno' => $data->icno, 'umsper' => $data->biodata->COOldID], ['class'=>'fa fa-download', 'target' => '_blank']) ; 
                                } 
                                 
                            }
                    ],
                     [
                        'label'=>'Status Surat',
                        'format' => 'raw',
                         'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'value'=>function ($data) { 
                         if($data->stat_surat == 0){
                         return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['status-surat', 'id' => $data->id]),'style'=>'background-color: transparent; 
                         border: none;', 'class' => 'fa fa-edit mapBtn']);
                         }if($data->stat_surat == 1){
                             return $data->statsurat; 
                         }
                      },
                    ],
                    [
                        'label'=>'Rekod Surat',
                        'format' => 'raw',
                         'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'value'=>function ($data) { 
                        if($data->diterima_oleh == NULL){
                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['rekod-surat', 'id' => $data->id]),'style'=>'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-edit mapBtn']);
                        }
                        else{
                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['rekod-surat', 'id' => $data->id]),'style'=>'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-eye mapBtn']);
                            
                         }
                      },
                    ],

                                

                ],
            ]); ?>
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


