<?php

use yii\helpers\Html;
use yii\helpers\Url; 
use yii\widgets\ActiveForm;
use kartik\grid\GridView;

?>
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true"><b>Permohonan Baharu</b></a>
                </li>
                
                
                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><b>Tempahan Diluluskan</b></a>
                </li>
                <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><b>Tuntutan Diluluskan</b></a>
                </li>
            <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><b>Permohonan Dibatalkan</b></a>
                </li>
               <li role="presentation" class=""><a href="#tab_content5" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><b>Dalam Tindakan Ketua Jabatan</b></a>
                </li>
            </ul>
        </div>
<div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tab_content1" aria-labelledby="home-tab">
       
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel"> 


            <div class="table-responsive">

                <?php
                $gridColumns3 = [
                    ['class' => 'yii\grid\SerialColumn', 
                     'header' => 'BIL',
                     'headerOptions' => ['style' => 'width:1%','class'=>'text-center'],
                     'contentOptions' => ['class'=>'text-center'],

                       ],
//                     [
//                           //'attribute' => 'CONm',
//                            'label' => 'JENIS PERMOHONAN',
//                            'headerOptions' => ['class'=>'text-center'],
//                            'contentOptions' => ['class'=>'text-center'],
//                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                return Html::a('<strong>'.strtoupper($model->borang->alt).'</strong>');
//                            }, 
//                                    'format' => 'html',
//                        ],
            [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                                if($model->idBorang == "TUNT")
                                {  
                                return Html::a('<strong>'.strtoupper($model->borang->alt).'</strong><br><u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["tiketpenerbangan/view-tuntutan", 'id' => $model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_mohon;
                                }
                                if(($model->idBorang == "CBDN") || ($model->idBorang == "CBLN") )
                                {
                                     return Html::a('<strong>'.strtoupper($model->borang->alt).'</strong><br><u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["tiketpenerbangan/adminview",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_mohon;
                                }
                            }, 
                                    'format' => 'html',
                        ],
                             [
                            'class' => 'yii\grid\ActionColumn',
                           //'attribute' => 'CONm',
                            'header' => ' STATUS BORANG',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'template' => '{update}',
                            //'header' => 'TINDAKAN',
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    
                                   
                                    $url = Url::to(['tiketpenerbangan/batal-borang', 'id' => $model->id]);
                                    return Html::button('<i class="fa fa-unlock-alt fa-lg"></i>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                    
                                },
                            ],
                        ],
                      
                                    [
                        'label' => 'PEMAKLUMAN KEPUTUSAN',
                        'format' => 'raw',
                        'headerOptions' => ['class'=>'text-center'],
                        'contentOptions' => ['class'=>'text-center'],
                        'value'=>function ($data) {
                        if($data->status_bsm == 'Draft Diluluskan'){
                            $checked = 'checked';
                        }
                        if($data->status_bsm == 'Draft Ditolak'){
                            $checked1 = 'checked';
                        }
                        if($data->status_bsm == 'Diluluskan' || $data->status_bsm == 'Tidak Diluluskan'){
                            return $data->statusbsm;
                        }
                        return Html::a('<input type="radio" name="'.$data->id.'" value="y'.$data->id.'" '.$checked.'><i class="fa fa-check"></i>').'  '.Html::a('<input type="radio" name="'.$data->id.'" value="n'.$data->id.'" '.$checked1.'><i class="fa fa-remove"></i>');
                      },
                       
                    ],
                              
            
                              
            
                    [        
                        'class' => 'yii\grid\CheckboxColumn',
                        'checkboxOptions' => function ($data) { 
                        if(($data->status_bsm=='Diluluskan' ||$data->status_bsm=='Tidak Diluluskan')){
                        return ['disabled' => 'disabled'];
                            }
                            return ['value' => $data->id, 'checked'=> true];
                            },
                     ],
                  

                        ];



                        echo GridView::widget([
                            'dataProvider' => $baharu,
                            'columns' => $gridColumns3,
                            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                            'beforeHeader' => [
                                [
                                    'columns' => [ ],
                                    'options' => ['class' => 'skip-export'] // remove this row from export
                                ]
                            ],
                            'toolbar' => [ 
                                ['content' => '']
                            ], 
                            'bordered' => true,
                            'striped' => false,
                            'condensed' => false,
                            'responsive' => true,
                            'hover' => true,  
                            'panel' => [
                                'type' => GridView::TYPE_DEFAULT,
                                'heading' => '<h6> '
                                . '<i class="fa fa-exclamation-triangle fa-lg" style="color:red"></i> Menunggu Tindakan Urusetia</h6>',
                            ],
                        ]);
                        ?>
            </div>
<div class="col-md-12 col-sm-12 col-xs-12" align="right"> 
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['class' => 'btn btn-primary', 'name' => 'hantar', 'value' => 'submit_2']) ?>
                </div>
      <?php ActiveForm::end(); ?>

        </div>
    </div>  

</div>  
</div>
    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel"> 


            <div class="table-responsive">

                <?php
                $gridColumns3 = [
                    ['class' => 'yii\grid\SerialColumn', 
                     'header' => 'BIL',
                     'headerOptions' => ['style' => 'width:1%','class'=>'text-center'],
                     'contentOptions' => ['class'=>'text-center'],

                       ],
//                     [
//                           //'attribute' => 'CONm',
//                            'label' => 'JENIS PERMOHONAN',
//                            'headerOptions' => ['class'=>'text-center'],
//                            'contentOptions' => ['class'=>'text-center'],
//                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                return Html::a('<strong>'.strtoupper($model->borang->alt).'</strong>');
//                            }, 
//                                    'format' => 'html',
//                        ],
            [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON',
                            'headerOptions' => ['style' => 'width:20%','class'=>'text-left'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                                if($model->idBorang == "TUNT")
                                {  
                                return Html::a('<strong>'.strtoupper($model->borang->alt).'</strong><br><u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["tiketpenerbangan/view-tuntutan", 'id' => $model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_mohon;
                                }
                                if(($model->idBorang == "CBDN") || ($model->idBorang == "CBLN") )
                                {
                                     return Html::a('<strong>'.strtoupper($model->borang->alt).'</strong><br><u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["tiketpenerbangan/adminview",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_mohon;
                                }
                            }, 
                                    'format' => 'html',
                        ],
                            
                                                        [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS SEMAKAN URUSETIA',
   'headerOptions' => ['style' => 'width:10%'],
//                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
//                                $ICNO = $model->icno;
                                if($model->no_peruntukan)
                                {
                                return Html::a($model->statusbsm.'<br><small>'.strtoupper($model->no_peruntukan).'</small>');
                                }
                                else
                                {
                                return Html::a($model->statusbsm.'<br><small>'.strtoupper($model->catatan).'</small>');
                                }
                            }, 
                                    'format' => 'html',
                        ],
                                    [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS PENTADBIRAN KEWANGAN',
   'headerOptions' => ['style' => 'width:10%'],
//                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
//                                $ICNO = $model->icno;
                                if($model->status == "TELAH DITEMPAH")
                                {
                                return Html::a($model->statusadmin.'<br><small>'.strtoupper($model->ulasan_a).'</small>');
                                }
                                else
                                {
                                return Html::a($model->statusadmin.'<br><small>'.strtoupper($model->ulasan_a).'</small>');
                                }
                            }, 
                                    'format' => 'html',
                        ],
                                    [
                            'class' => 'yii\grid\ActionColumn',
                           //'attribute' => 'CONm',
                            'header' => 'KEMASKINI KEPUTUSAN',
                            'headerOptions' => ['class'=>'text-center'],
                                           'headerOptions' => ['style' => 'width:10%'],

                            'contentOptions' => ['class'=>'text-center'],
                            'template' => '{update}',
                            //'header' => 'TINDAKAN',
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    $url = Url::to(['tindakan_tempah', 'id' => $model->id]);
                                    return Html::button('<i class="fa fa-pencil fa-lg"></i>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                    
                                },
                            ],
                        ],
//                          [
//                        'label' => 'STATUS KEPUTUSAN',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                        'value'=>function ($data) {
//                        if($data->status_bsm == 'Draft Diluluskan'){
//                            $checked = 'checked';
//                        }
//                        if($data->status_bsm == 'Draft Ditolak'){
//                            $checked1 = 'checked';
//                        }
//                        if($data->status_bsm == 'Diluluskan' || $data->status_bsm == 'Tidak Diluluskan'){
//                            return $data->statusbsm;
//                        }
//                        return Html::a('<input type="radio" name="'.$data->id.'" value="y'.$data->id.'" '.$checked.'><i class="fa fa-check"></i>').'  '.Html::a('<input type="radio" name="'.$data->id.'" value="n'.$data->id.'" '.$checked1.'><i class="fa fa-remove"></i>');
//                      },
//                       
//                    ],
            
                              
            
//                    [        
//                        'class' => 'yii\grid\CheckboxColumn',
//                        'checkboxOptions' => function ($data) { 
//                        if(($data->status_bsm=='Diluluskan' ||$data->status_bsm=='Tidak Diluluskan')){
//                        return ['disabled' => 'disabled'];
//                            }
//                            return ['value' => $data->id, 'checked'=> true];
//                            },
//                     ],
                  

                        ];



                        echo GridView::widget([
                            'dataProvider' => $lulus,
                            'columns' => $gridColumns3,
                            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                            'beforeHeader' => [
                                [
                                    'columns' => [ ],
                                    'options' => ['class' => 'skip-export'] // remove this row from export
                                ]
                            ],
                            'toolbar' => [ 
                                ['content' => '']
                            ], 
                            'bordered' => true,
                            'striped' => false,
                            'condensed' => false,
                            'responsive' => true,
                            'hover' => true,  
                            'panel' => [
                                'type' => GridView::TYPE_DEFAULT,
                                'heading' => '<h6> '
                                . '<i class="fa fa-check fa-lg" style="color:green"></i> Permohonan / Tuntutan Tiket Penerbangan Yang Telah Disemak dan Diluluskan</h6>',
                            ],
                        ]);
                        ?>
            </div>


        </div>
    </div>  

</div>
    </div>
    
    <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel"> 


            <div class="table-responsive">

                <?php
                $gridColumns3 = [
                    ['class' => 'yii\grid\SerialColumn', 
                     'header' => 'BIL',
                     'headerOptions' => ['style' => 'width:1%','class'=>'text-center'],
                     'contentOptions' => ['class'=>'text-center'],

                       ],
//                     [
//                           //'attribute' => 'CONm',
//                            'label' => 'JENIS PERMOHONAN',
//                            'headerOptions' => ['class'=>'text-center'],
//                            'contentOptions' => ['class'=>'text-center'],
//                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                return Html::a('<strong>'.strtoupper($model->borang->alt).'</strong>');
//                            }, 
//                                    'format' => 'html',
//                        ],
            [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON',
                            'headerOptions' => ['style' => 'width:20%','class'=>'text-left'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                                if($model->idBorang == "TUNT")
                                {  
                                return Html::a('<strong>'.strtoupper($model->borang->alt).'</strong><br><u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["tiketpenerbangan/view-tuntutan", 'id' => $model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_mohon;
                                }
                                if(($model->idBorang == "CBDN") || ($model->idBorang == "CBLN") )
                                {
                                     return Html::a('<strong>'.strtoupper($model->borang->alt).'</strong><br><u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["tiketpenerbangan/adminview",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_mohon;
                                }
                            }, 
                                    'format' => 'html',
                        ],
                            
                                                        [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS KEPUTUSAN',
   'headerOptions' => ['style' => 'width:10%'],
//                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
//                                $ICNO = $model->icno;
                                if($model->no_peruntukan)
                                {
                                return Html::a($model->statusbsm.'<br><small>'.strtoupper($model->no_peruntukan).'</small>');
                                }
                                else
                                {
                                return Html::a($model->statusbsm.'<br><small>'.strtoupper($model->catatan).'</small>');
                                }
                            }, 
                                    'format' => 'html',
                        ], 
                                    [
                            'class' => 'yii\grid\ActionColumn',
                           //'attribute' => 'CONm',
                            'header' => 'KEMASKINI KEPUTUSAN',
                            'headerOptions' => ['class'=>'text-center'],
                                           'headerOptions' => ['style' => 'width:10%'],

                            'contentOptions' => ['class'=>'text-center'],
                            'template' => '{update}',
                            //'header' => 'TINDAKAN',
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    $url = Url::to(['tindakan_bsmtiket', 'id' => $model->id]);
                                    return Html::button('<i class="fa fa-pencil fa-lg"></i>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                    
                                },
                            ],
                        ],
//                          [
//                        'label' => 'STATUS KEPUTUSAN',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                        'value'=>function ($data) {
//                        if($data->status_bsm == 'Draft Diluluskan'){
//                            $checked = 'checked';
//                        }
//                        if($data->status_bsm == 'Draft Ditolak'){
//                            $checked1 = 'checked';
//                        }
//                        if($data->status_bsm == 'Diluluskan' || $data->status_bsm == 'Tidak Diluluskan'){
//                            return $data->statusbsm;
//                        }
//                        return Html::a('<input type="radio" name="'.$data->id.'" value="y'.$data->id.'" '.$checked.'><i class="fa fa-check"></i>').'  '.Html::a('<input type="radio" name="'.$data->id.'" value="n'.$data->id.'" '.$checked1.'><i class="fa fa-remove"></i>');
//                      },
//                       
//                    ],
            
                              
            
//                    [        
//                        'class' => 'yii\grid\CheckboxColumn',
//                        'checkboxOptions' => function ($data) { 
//                        if(($data->status_bsm=='Diluluskan' ||$data->status_bsm=='Tidak Diluluskan')){
//                        return ['disabled' => 'disabled'];
//                            }
//                            return ['value' => $data->id, 'checked'=> true];
//                            },
//                     ],
                  

                        ];



                        echo GridView::widget([
                            'dataProvider' => $lulust,
                            'columns' => $gridColumns3,
                            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                            'beforeHeader' => [
                                [
                                    'columns' => [ ],
                                    'options' => ['class' => 'skip-export'] // remove this row from export
                                ]
                            ],
                            'toolbar' => [ 
                                ['content' => '']
                            ], 
                            'bordered' => true,
                            'striped' => false,
                            'condensed' => false,
                            'responsive' => true,
                            'hover' => true,  
                            'panel' => [
                                'type' => GridView::TYPE_DEFAULT,
                                'heading' => '<h6> '
                                . '<i class="fa fa-check fa-lg" style="color:green"></i> Permohonan / Tuntutan Tiket Penerbangan Yang Telah Disemak dan Diluluskan</h6>',
                            ],
                        ]);
                        ?>
            </div>


        </div>
    </div>  

</div>
    </div>
    
    <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel"> 


            <div class="table-responsive">

                <?php
                $gridColumns4 = [
                    ['class' => 'yii\grid\SerialColumn', 
                     'header' => 'BIL',
                     'headerOptions' => ['style' => 'width:1%','class'=>'text-center'],
                     'contentOptions' => ['class'=>'text-center'],

                       ],
//                     [
//                           //'attribute' => 'CONm',
//                            'label' => 'JENIS PERMOHONAN',
//                            'headerOptions' => ['class'=>'text-center'],
//                            'contentOptions' => ['class'=>'text-center'],
//                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                return Html::a('<strong>'.strtoupper($model->borang->alt).'</strong>');
//                            }, 
//                                    'format' => 'html',
//                        ],
            [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON',
                            'headerOptions' => ['style' => 'width:20%','class'=>'text-left'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                                if($model->idBorang == "TUNT")
                                {  
                                return Html::a('<strong>'.strtoupper($model->borang->alt).'</strong><br><u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["tiketpenerbangan/view-tuntutan", 'id' => $model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_mohon;
                                }
                                if(($model->idBorang == "CBDN") || ($model->idBorang == "CBLN") )
                                {
                                     return Html::a('<strong>'.strtoupper($model->borang->alt).'</strong><br><u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["tiketpenerbangan/adminview",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_mohon;
                                }
                            }, 
                                    'format' => 'html',
                        ],
                            
                                                        
//                          [
//                        'label' => 'STATUS KEPUTUSAN',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                        'value'=>function ($data) {
//                        if($data->status_bsm == 'Draft Diluluskan'){
//                            $checked = 'checked';
//                        }
//                        if($data->status_bsm == 'Draft Ditolak'){
//                            $checked1 = 'checked';
//                        }
//                        if($data->status_bsm == 'Diluluskan' || $data->status_bsm == 'Tidak Diluluskan'){
//                            return $data->statusbsm;
//                        }
//                        return Html::a('<input type="radio" name="'.$data->id.'" value="y'.$data->id.'" '.$checked.'><i class="fa fa-check"></i>').'  '.Html::a('<input type="radio" name="'.$data->id.'" value="n'.$data->id.'" '.$checked1.'><i class="fa fa-remove"></i>');
//                      },
//                       
//                    ],
            
                              
            
//                    [        
//                        'class' => 'yii\grid\CheckboxColumn',
//                        'checkboxOptions' => function ($data) { 
//                        if(($data->status_bsm=='Diluluskan' ||$data->status_bsm=='Tidak Diluluskan')){
//                        return ['disabled' => 'disabled'];
//                            }
//                            return ['value' => $data->id, 'checked'=> true];
//                            },
//                     ],
                  

                        ];



                        echo GridView::widget([
                            'dataProvider' => $batal,
                            'columns' => $gridColumns4,
                            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                            'beforeHeader' => [
                                [
                                    'columns' => [ ],
                                    'options' => ['class' => 'skip-export'] // remove this row from export
                                ]
                            ],
                            'toolbar' => [ 
                                ['content' => '']
                            ], 
                            'bordered' => true,
                            'striped' => false,
                            'condensed' => false,
                            'responsive' => true,
                            'hover' => true,  
                            'panel' => [
                                'type' => GridView::TYPE_DEFAULT,
                                'heading' => '<h6> '
                                . '<i class="fa fa-times fa-lg" style="color:red"></i> Permohonan / Tuntutan Tiket Penerbangan Yang Dibatalkan</h6>',
                            ],
                        ]);
                        ?>
            </div>


        </div>
    </div>  

</div>
    </div>
    
    <div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="profile-tab">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel"> 


            <div class="table-responsive">

                <?php
                $gridColumns7 = [
                    ['class' => 'yii\grid\SerialColumn', 
                     'header' => 'BIL',
                     'headerOptions' => ['style' => 'width:1%','class'=>'text-center'],
                     'contentOptions' => ['class'=>'text-center'],

                       ],
//                     [
//                           //'attribute' => 'CONm',
//                            'label' => 'JENIS PERMOHONAN',
//                            'headerOptions' => ['class'=>'text-center'],
//                            'contentOptions' => ['class'=>'text-center'],
//                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                return Html::a('<strong>'.strtoupper($model->borang->alt).'</strong>');
//                            }, 
//                                    'format' => 'html',
//                        ],
            [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON',
                            'headerOptions' => ['style' => 'width:20%','class'=>'text-left'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                                if($model->idBorang == "TUNT")
                                {  
                                return Html::a('<strong>'.strtoupper($model->borang->alt).'</strong><br><u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["tiketpenerbangan/view-tuntutan", 'id' => $model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_mohon;
                                }
                                if(($model->idBorang == "CBDN") || ($model->idBorang == "CBLN") )
                                {
                                     return Html::a('<strong>'.strtoupper($model->borang->alt).'</strong><br><u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["tiketpenerbangan/adminview",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_mohon;
                                }
                            }, 
                                    'format' => 'html',
                        ],
                            
                                                        
//                          [
//                        'label' => 'STATUS KEPUTUSAN',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                        'value'=>function ($data) {
//                        if($data->status_bsm == 'Draft Diluluskan'){
//                            $checked = 'checked';
//                        }
//                        if($data->status_bsm == 'Draft Ditolak'){
//                            $checked1 = 'checked';
//                        }
//                        if($data->status_bsm == 'Diluluskan' || $data->status_bsm == 'Tidak Diluluskan'){
//                            return $data->statusbsm;
//                        }
//                        return Html::a('<input type="radio" name="'.$data->id.'" value="y'.$data->id.'" '.$checked.'><i class="fa fa-check"></i>').'  '.Html::a('<input type="radio" name="'.$data->id.'" value="n'.$data->id.'" '.$checked1.'><i class="fa fa-remove"></i>');
//                      },
//                       
//                    ],
            
                              
            
//                    [        
//                        'class' => 'yii\grid\CheckboxColumn',
//                        'checkboxOptions' => function ($data) { 
//                        if(($data->status_bsm=='Diluluskan' ||$data->status_bsm=='Tidak Diluluskan')){
//                        return ['disabled' => 'disabled'];
//                            }
//                            return ['value' => $data->id, 'checked'=> true];
//                            },
//                     ],
                  

                        ];



                        echo GridView::widget([
                            'dataProvider' => $kjj,
                            'columns' => $gridColumns7,
                            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                            'beforeHeader' => [
                                [
                                    'columns' => [ ],
                                    'options' => ['class' => 'skip-export'] // remove this row from export
                                ]
                            ],
                            'toolbar' => [ 
                                ['content' => '']
                            ], 
                            'bordered' => true,
                            'striped' => false,
                            'condensed' => false,
                            'responsive' => true,
                            'hover' => true,  
                            'panel' => [
                                'type' => GridView::TYPE_DEFAULT,
                                'heading' => '<h6> '
                                . '<i class="fa fa-search fa-lg" style="color:red"></i> DALAM TINDAKAN KETUA JABATAN BSM</h6>',
                            ],
                        ]);
                        ?>
            </div>


        </div>
    </div>  

</div>
    </div>
</div>
</div>