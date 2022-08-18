<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

error_reporting(0);
?>
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" 
                        aria-expanded="true"><b>Hadiah Pergerakan Gaji (HPG)</b></a>
                </li>
                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" 
                 data-toggle="tab" aria-expanded="false"><b>Elaun Tesis</b></a>
                </li>
                             <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab" 
                 data-toggle="tab" aria-expanded="false"><b>Elaun Akhir Pengajian</b></a>
                </li>
                 <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab" 
                 data-toggle="tab" aria-expanded="false"><b>Yuran Pengajian</b></a>
                </li>
            <li role="presentation" class=""><a href="#tab_content5" role="tab" id="profile-tab" 
                 data-toggle="tab" aria-expanded="false"><b>IELTS</b></a>
                </li>
                <li role="presentation" class=""><a href="#tab_content6" role="tab" id="profile-tab" 
                 data-toggle="tab" aria-expanded="false"><b>Visa & Insurans</b></a>
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

            [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                                if($model->idBorang == "30")
                                {  
                                return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lapordiri/kgt", 'id' => $model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m.
                                        '<br><small><b>STATUS PERJAWATAN: '.$model->status.'</b>';
                                }
                                if($model->idBorang == "35") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lapordiri/view-tuntutan-tesis",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                                 if($model->idBorang == "37") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lapordiri/view-tuntutan-akhir",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                            }, 
                                    'format' => 'html',
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
//                            return ['value' => $data->id, 'checked'=> true];
                            },
                     ],
                  

                        ];



                        echo GridView::widget([
                            'dataProvider' => $semak,
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
        </div>
    </div>  

</div>  
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

            [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                                if($model->idBorang == "30")
                                {  
                                return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lapordiri/kgt", 'id' => $model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m.
                                        '<br><small><b>STATUS PERJAWATAN: '.$model->status.'</b>';
                                }
                                if($model->idBorang == "35") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lapordiri/view-tuntutan-tesis",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                                 if($model->idBorang == "37") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lapordiri/view-tuntutan-akhir",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                                 if($model->idBorang == "46") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["tuntutan-yuran/view-tuntutan-yuran",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                            }, 
                                    'format' => 'html',
                        ],        
                         [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS KEPUTUSAN',
                       'headerOptions' => ['style' => 'width:50%'],
//                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
//                                $ICNO = $model->icno;
                                if($model->status_bsm =="Diluluskan")
                                {
                                return Html::a($model->statusbsm.'<br><small>'.strtoupper($model->catatan).'</small>');
                                }
                                else
                                {
                                    echo '-';
                                }
                            }, 
                                    'format' => 'html',
                        ], 
                              [
                            'class' => 'yii\grid\ActionColumn',
                           //'attribute' => 'CONm',
                            'header' => 'KEMASKINI KEPUTUSAN',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'template' => '{update}',
                            //'header' => 'TINDAKAN',
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    $url = Url::to(['cbadmin/tindakanbsm_akhir', 'id' => $model->id]);
                                    return Html::button('<i class="fa fa-pencil fa-lg"></i>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                    
                                },
                            ],
                        ],
            
            
//                    [        
//                        'class' => 'yii\grid\CheckboxColumn',
//                        'checkboxOptions' => function ($data) { 
//                        if(($data->status_bsm=='Diluluskan' ||$data->status_bsm=='Tidak Diluluskan')){
//                        return ['disabled' => 'disabled'];
//                            }
//                            return ['value' => $data->id, 'checked'=> true];
//                            },
//                     ],
//                  

                        ];



                        echo GridView::widget([
                            'dataProvider' => $lulush,
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
                                . '<i class="fa fa-check-square fa-lg" style="color:green"></i> Telah Diluluskan Bahagian Sumber Manusia</h6>',
                            ],
                        ]);
                        ?>
            </div>


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

            [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                                if($model->idBorang == "30")
                                {  
                                return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lapordiri/kgt", 'id' => $model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m.
                                        '<br><small><b>STATUS PERJAWATAN: '.$model->status.'</b>';
                                }
                                if($model->idBorang == "35") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lapordiri/view-tuntutan-tesis",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                                 if($model->idBorang == "37") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lapordiri/view-tuntutan-akhir",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                            }, 
                                    'format' => 'html',
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
//                            return ['value' => $data->id, 'checked'=> true];
                            },
                     ],
                  

                        ];



                        echo GridView::widget([
                            'dataProvider' => $semakt,
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
        </div>
    </div>  

</div>  
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

            [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                                if($model->idBorang == "30")
                                {  
                                return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lapordiri/kgt", 'id' => $model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m.
                                        '<br><small><b>STATUS PERJAWATAN: '.$model->status.'</b>';
                                }
                                if($model->idBorang == "35") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lapordiri/view-tuntutan-tesis",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                                 if($model->idBorang == "37") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lapordiri/view-tuntutan-akhir",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                            }, 
                                    'format' => 'html',
                        ],        
                                    [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS KEPUTUSAN',
                       'headerOptions' => ['style' => 'width:50%'],
//                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
//                                $ICNO = $model->icno;
                                if($model->status_bsm =="Diluluskan")
                                {
                                return Html::a($model->statusbsm.'<br><small>'.strtoupper($model->catatan).'</small>');
                                }
                                
                                else
                                {
                                    echo '-';
                                }
                            }, 
                                    'format' => 'html',
                        ], 
            
                              [
                            'class' => 'yii\grid\ActionColumn',
                           //'attribute' => 'CONm',
                            'header' => 'KEMASKINI KEPUTUSAN',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'template' => '{update}',
                            //'header' => 'TINDAKAN',
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    $url = Url::to(['cbadmin/tindakanbsm_akhir', 'id' => $model->id]);
                                    return Html::button('<i class="fa fa-pencil fa-lg"></i>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                    
                                },
                            ],
                        ],
            
            
//                    [        
//                        'class' => 'yii\grid\CheckboxColumn',
//                        'checkboxOptions' => function ($data) { 
//                        if(($data->status_bsm=='Diluluskan' ||$data->status_bsm=='Tidak Diluluskan')){
//                        return ['disabled' => 'disabled'];
//                            }
//                            return ['value' => $data->id, 'checked'=> true];
//                            },
//                     ],
//                  

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
                                . '<i class="fa fa-check-square fa-lg" style="color:green"></i> Telah Diluluskan Bahagian Sumber Manusia</h6>',
                            ],
                        ]);
                        ?>
            </div>


        </div>
    </div>  

</div>  
    <div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel"> 


            <div class="table-responsive">

                <?php
                $gridColumns6 = [
                    ['class' => 'yii\grid\SerialColumn', 
                     'header' => 'BIL',
                     'headerOptions' => ['style' => 'width:1%','class'=>'text-center'],
                     'contentOptions' => ['class'=>'text-center'],

                       ],

            [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON',
                     'headerOptions' => ['style' => 'width:40%','class'=>'text-center'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                                if($model->idBorang == "30")
                                {  
                                return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lapordiri/kgt", 'id' => $model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m.
                                        '<br><small><b>STATUS PERJAWATAN: '.$model->status.'</b>';
                                }
                                if($model->idBorang == "35") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lapordiri/view-tuntutan-tesis",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                                 if($model->idBorang == "37") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lapordiri/view-tuntutan-akhir",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                            }, 
                                    'format' => 'html',
                        ],        
                                    [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS KEPUTUSAN',
                       'headerOptions' => ['style' => 'width:50%'],
//                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
//                                $ICNO = $model->icno;
                                if($model->status_bsm =="Tidak Diluluskan")
                                {
                                return Html::a($model->statusbsm.'<br><small>'.strtoupper($model->catatan).'</small>');
                                }
                                else
                                {
                                    echo '-';
                                }
                            }, 
                                    'format' => 'html',
                        ], 
                                    
                                    
                                    
//                                    [
//                        'label'=>'KEMASKINI KEPUTUSAN',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                        'value'=>function ($data) {
//                       
//                        if($data->terima == NULL){
//                        $ICNO = $data->icno;
//                        
//                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['cbadmin/tindakanbsm_akhir', 'id' => $data->id]),'style'=>'background-color: transparent; 
//                        border: none;', 'class' => 'fa fa-edit fa-lg mapBtn']);}
////                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]);}
//                        else{
//                            return Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO ])|  Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
//                        }
//                      },
//                           
//                    ],
                              [
                            'class' => 'yii\grid\ActionColumn',
                           //'attribute' => 'CONm',
                            'header' => 'KEMASKINI KEPUTUSAN',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'template' => '{update}',
                            //'header' => 'TINDAKAN',
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    $url = Url::to(['cbadmin/tindakanbsm_akhir', 'id' => $model->id]);
                                    return Html::button('<i class="fa fa-pencil fa-lg"></i>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                    
                                },
                            ],
                        ],
            
                              
            
//                    [        
//                        'class' => 'yii\grid\CheckboxColumn',
//                        'checkboxOptions' => function ($data) { 
//                        if(($data->status_bsm=='Diluluskan' ||$data->status_bsm=='Tidak Diluluskan')){
//                        return ['disabled' => 'disabled'];
//                            }
//                            return ['value' => $data->id, 'checked'=> true];
//                            },
//                     ],
//                  

                        ];



                        echo GridView::widget([
                            'dataProvider' => $tolakw,
                            'columns' => $gridColumns6,
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
                                . '<i class="fa fa-times fa-lg" style="color:red"></i> Tidak Diluluskan Bahagian Sumber Manusia</h6>',
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

            [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                                if($model->idBorang == "30")
                                {  
                                return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lapordiri/kgt", 'id' => $model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m.
                                        '<br><small><b>STATUS PERJAWATAN: '.$model->status.'</b>';
                                }
                                if($model->idBorang == "35") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lapordiri/view-tuntutan-tesis",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                                 if($model->idBorang == "37") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lapordiri/view-tuntutan-akhir",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                            }, 
                                    'format' => 'html',
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
                        return Html::a('<input type="radio" name="'.$data->id.'" value="y'.$data->id.'" '.$checked.'>')
                                ;
                      },
                       
                    ],
            
                              
            
                    [        
                        'class' => 'yii\grid\CheckboxColumn',
                        'checkboxOptions' => function ($data) { 
                        if(($data->status_bsm=='Diluluskan' ||$data->status_bsm=='Tidak Diluluskan')){
                        return ['disabled' => 'disabled'];
                            }
//                            return ['value' => $data->id, 'checked'=> true];
                            },
                     ],
                  

                        ];



                        echo GridView::widget([
                            'dataProvider' => $semakp,
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
        </div>
    </div> 
    

</div>  
            
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

            [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON',
                     'headerOptions' => ['style' => 'width:40%','class'=>'text-center'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                                if($model->idBorang == "30")
                                {  
                                return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lapordiri/kgt", 'id' => $model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m.
                                        '<br><small><b>STATUS PERJAWATAN: '.$model->status.'</b>';
                                }
                                if($model->idBorang == "35") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lapordiri/view-tuntutan-tesis",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                                 if($model->idBorang == "37") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lapordiri/view-tuntutan-akhir",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                            }, 
                                    'format' => 'html',
                        ],        
                                    [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS KEPUTUSAN',
                       'headerOptions' => ['style' => 'width:50%'],
//                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
//                                $ICNO = $model->icno;
                                if($model->status_bsm =="Diluluskan" )
                                {
                                return Html::a($model->statusbsm.'<br><small>'.strtoupper($model->catatan).'</small>');
                                }
                                else
                                {
                                    echo '-';
                                }
                            }, 
                                    'format' => 'html',
                        ], 
                                    
                                    
                                    
//                                    [
//                        'label'=>'KEMASKINI KEPUTUSAN',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                        'value'=>function ($data) {
//                       
//                        if($data->terima == NULL){
//                        $ICNO = $data->icno;
//                        
//                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['cbadmin/tindakanbsm_akhir', 'id' => $data->id]),'style'=>'background-color: transparent; 
//                        border: none;', 'class' => 'fa fa-edit fa-lg mapBtn']);}
////                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]);}
//                        else{
//                            return Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO ])|  Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
//                        }
//                      },
//                           
//                    ],
                              [
                            'class' => 'yii\grid\ActionColumn',
                           //'attribute' => 'CONm',
                            'header' => 'KEMASKINI KEPUTUSAN',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'template' => '{update}',
                            //'header' => 'TINDAKAN',
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    $url = Url::to(['cbadmin/tindakanbsm_akhir', 'id' => $model->id]);
                                    return Html::button('<i class="fa fa-pencil fa-lg"></i>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                    
                                },
                            ],
                        ],
            
                              
            
//                    [        
//                        'class' => 'yii\grid\CheckboxColumn',
//                        'checkboxOptions' => function ($data) { 
//                        if(($data->status_bsm=='Diluluskan' ||$data->status_bsm=='Tidak Diluluskan')){
//                        return ['disabled' => 'disabled'];
//                            }
//                            return ['value' => $data->id, 'checked'=> true];
//                            },
//                     ],
//                  

                        ];



                        echo GridView::widget([
                            'dataProvider' => $lulusp,
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
                                . '<i class="fa fa-check-square fa-lg" style="color:green"></i> Telah Diluluskan Bahagian Sumber Manusia</h6>',
                            ],
                        ]);
                        ?>
            </div>


        </div>
    </div>  

</div> 
        
             <div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel"> 


            <div class="table-responsive">

                <?php
                $gridColumns5 = [
                    ['class' => 'yii\grid\SerialColumn', 
                     'header' => 'BIL',
                     'headerOptions' => ['style' => 'width:1%','class'=>'text-center'],
                     'contentOptions' => ['class'=>'text-center'],

                       ],

            [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON',
                     'headerOptions' => ['style' => 'width:40%','class'=>'text-center'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                                if($model->idBorang == "30")
                                {  
                                return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lapordiri/kgt", 'id' => $model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m.
                                        '<br><small><b>STATUS PERJAWATAN: '.$model->status.'</b>';
                                }
                                if($model->idBorang == "35") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lapordiri/view-tuntutan-tesis",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                                 if($model->idBorang == "37") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lapordiri/view-tuntutan-akhir",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                            }, 
                                    'format' => 'html',
                        ],        
                                    [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS KEPUTUSAN',
                       'headerOptions' => ['style' => 'width:50%'],
//                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
//                                $ICNO = $model->icno;
                                if($model->status_bsm =="Tidak Diluluskan")
                                {
                                return Html::a($model->statusbsm.'<br><small>'.strtoupper($model->catatan).'</small>');
                                }
                                else
                                {
                                    echo '-';
                                }
                            }, 
                                    'format' => 'html',
                        ], 
                                    
                                    
                                    
//                                    [
//                        'label'=>'KEMASKINI KEPUTUSAN',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                        'value'=>function ($data) {
//                       
//                        if($data->terima == NULL){
//                        $ICNO = $data->icno;
//                        
//                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['cbadmin/tindakanbsm_akhir', 'id' => $data->id]),'style'=>'background-color: transparent; 
//                        border: none;', 'class' => 'fa fa-edit fa-lg mapBtn']);}
////                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]);}
//                        else{
//                            return Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO ])|  Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
//                        }
//                      },
//                           
//                    ],
                              [
                            'class' => 'yii\grid\ActionColumn',
                           //'attribute' => 'CONm',
                            'header' => 'KEMASKINI KEPUTUSAN',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'template' => '{update}',
                            //'header' => 'TINDAKAN',
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    $url = Url::to(['cbadmin/tindakanbsm_akhir', 'id' => $model->id]);
                                    return Html::button('<i class="fa fa-pencil fa-lg"></i>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                    
                                },
                            ],
                        ],
            
                              
            
//                    [        
//                        'class' => 'yii\grid\CheckboxColumn',
//                        'checkboxOptions' => function ($data) { 
//                        if(($data->status_bsm=='Diluluskan' ||$data->status_bsm=='Tidak Diluluskan')){
//                        return ['disabled' => 'disabled'];
//                            }
//                            return ['value' => $data->id, 'checked'=> true];
//                            },
//                     ],
//                  

                        ];



                        echo GridView::widget([
                            'dataProvider' => $tolakp,
                            'columns' => $gridColumns5,
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
                                . '<i class="fa fa-times fa-lg" style="color:red"></i> Tidak Diluluskan Bahagian Sumber Manusia</h6>',
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
                $gridColumns6 = [
                    ['class' => 'yii\grid\SerialColumn', 
                     'header' => 'BIL',
                     'headerOptions' => ['style' => 'width:1%','class'=>'text-center'],
                     'contentOptions' => ['class'=>'text-center'],

                       ],

            [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                                if($model->idBorang == "30")
                                {  
                                return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lapordiri/kgt", 'id' => $model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m.
                                        '<br><small><b>STATUS PERJAWATAN: '.$model->status.'</b>';
                                }
                                if($model->idBorang == "35") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lapordiri/view-tuntutan-tesis",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                                 if($model->idBorang == "37") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lapordiri/view-tuntutan-akhir",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                                if($model->idBorang == "46") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["tuntutan-yuran/view-tuntutan-yuran",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                            }, 
                                    'format' => 'html',
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
                        return Html::a('<input type="radio" name="'.$data->id.'" value="y'.$data->id.'" '.$checked.'>')
                                ;
                      },
                       
                    ],
            
                              
            
                    [        
                        'class' => 'yii\grid\CheckboxColumn',
                        'checkboxOptions' => function ($data) { 
                        if(($data->status_bsm=='Diluluskan' ||$data->status_bsm=='Tidak Diluluskan')){
                        return ['disabled' => 'disabled'];
                            }
//                            return ['value' => $data->id, 'checked'=> true];
                            },
                     ],
                  

                        ];



                        echo GridView::widget([
                            'dataProvider' => $semaky,
                            'columns' => $gridColumns6,
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
        </div>
    </div> 
    

</div>  
            
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

            [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON',
                     'headerOptions' => ['style' => 'width:40%','class'=>'text-center'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                                
                                
                                 if($model->idBorang == "46") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["tuntutan-yuran/view-tuntutan-yuran",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                            }, 
                                    'format' => 'html',
                        ],        
                                    [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS KEPUTUSAN',
                       'headerOptions' => ['style' => 'width:50%'],
//                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
//                                $ICNO = $model->icno;
                                if($model->status_bsm =="Diluluskan" )
                                {
                                return Html::a($model->statusbsm.'<br><small>'.strtoupper($model->catatan).'</small>');
                                }
                                else
                                {
                                    echo '-';
                                }
                            }, 
                                    'format' => 'html',
                        ], 
                                    
                                    
                                    
//                                    [
//                        'label'=>'KEMASKINI KEPUTUSAN',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                        'value'=>function ($data) {
//                       
//                        if($data->terima == NULL){
//                        $ICNO = $data->icno;
//                        
//                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['cbadmin/tindakanbsm_akhir', 'id' => $data->id]),'style'=>'background-color: transparent; 
//                        border: none;', 'class' => 'fa fa-edit fa-lg mapBtn']);}
////                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]);}
//                        else{
//                            return Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO ])|  Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
//                        }
//                      },
//                           
//                    ],
                              [
                            'class' => 'yii\grid\ActionColumn',
                           //'attribute' => 'CONm',
                            'header' => 'KEMASKINI KEPUTUSAN',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'template' => '{update}',
                            //'header' => 'TINDAKAN',
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    $url = Url::to(['cbadmin/tindakanbsm_akhir', 'id' => $model->id]);
                                    return Html::button('<i class="fa fa-pencil fa-lg"></i>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                    
                                },
                            ],
                        ],
            
                              
            
//                    [        
//                        'class' => 'yii\grid\CheckboxColumn',
//                        'checkboxOptions' => function ($data) { 
//                        if(($data->status_bsm=='Diluluskan' ||$data->status_bsm=='Tidak Diluluskan')){
//                        return ['disabled' => 'disabled'];
//                            }
//                            return ['value' => $data->id, 'checked'=> true];
//                            },
//                     ],
//                  

                        ];



                        echo GridView::widget([
                            'dataProvider' => $lulusy,
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
                                . '<i class="fa fa-check-square fa-lg" style="color:green"></i> Telah Diluluskan Bahagian Sumber Manusia</h6>',
                            ],
                        ]);
                        ?>
            </div>


        </div>
    </div>  

</div> 
        
             <div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel"> 


            <div class="table-responsive">

                <?php
                $gridColumns5 = [
                    ['class' => 'yii\grid\SerialColumn', 
                     'header' => 'BIL',
                     'headerOptions' => ['style' => 'width:1%','class'=>'text-center'],
                     'contentOptions' => ['class'=>'text-center'],

                       ],

            [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON',
                     'headerOptions' => ['style' => 'width:40%','class'=>'text-center'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                              
                                 if($model->idBorang == "46") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["tuntutan-yuran/view-tuntutan-yuran",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                            }, 
                                    'format' => 'html',
                        ],        
                                    [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS KEPUTUSAN',
                       'headerOptions' => ['style' => 'width:50%'],
//                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
//                                $ICNO = $model->icno;
                                if($model->status_bsm =="Tidak Diluluskan")
                                {
                                return Html::a($model->statusbsm.'<br><small>'.strtoupper($model->catatan).'</small>');
                                }
                                else
                                {
                                    echo '-';
                                }
                            }, 
                                    'format' => 'html',
                        ], 
                                    
                                    
                                    
//                                    [
//                        'label'=>'KEMASKINI KEPUTUSAN',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                        'value'=>function ($data) {
//                       
//                        if($data->terima == NULL){
//                        $ICNO = $data->icno;
//                        
//                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['cbadmin/tindakanbsm_akhir', 'id' => $data->id]),'style'=>'background-color: transparent; 
//                        border: none;', 'class' => 'fa fa-edit fa-lg mapBtn']);}
////                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]);}
//                        else{
//                            return Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO ])|  Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
//                        }
//                      },
//                           
//                    ],
                              [
                            'class' => 'yii\grid\ActionColumn',
                           //'attribute' => 'CONm',
                            'header' => 'KEMASKINI KEPUTUSAN',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'template' => '{update}',
                            //'header' => 'TINDAKAN',
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    $url = Url::to(['cbadmin/tindakanbsm_akhir', 'id' => $model->id]);
                                    return Html::button('<i class="fa fa-pencil fa-lg"></i>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                    
                                },
                            ],
                        ],
            
                              
            
//                    [        
//                        'class' => 'yii\grid\CheckboxColumn',
//                        'checkboxOptions' => function ($data) { 
//                        if(($data->status_bsm=='Diluluskan' ||$data->status_bsm=='Tidak Diluluskan')){
//                        return ['disabled' => 'disabled'];
//                            }
//                            return ['value' => $data->id, 'checked'=> true];
//                            },
//                     ],
//                  

                        ];



                        echo GridView::widget([
                            'dataProvider' => $tolaky,
                            'columns' => $gridColumns5,
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
                                . '<i class="fa fa-times fa-lg" style="color:red"></i> Tidak Diluluskan Bahagian Sumber Manusia</h6>',
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
                $gridColumns6 = [
                    ['class' => 'yii\grid\SerialColumn', 
                     'header' => 'BIL',
                     'headerOptions' => ['style' => 'width:1%','class'=>'text-center'],
                     'contentOptions' => ['class'=>'text-center'],

                       ],

            [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                             
                                if($model->idBorang == "50") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["tuntutan-ielts/view-tuntutan-ielts",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                            }, 
                                    'format' => 'html',
                        ],  
                                    [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS SEMAKAN',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                             
                                switch ($model->status_semakan) {
                                    case 'Layak Dipertimbangkan':
                                        $status = '<span class="label label-success"> DIPROSES </span>';
                                        break;
                                    case 'Tidak Layak Dipertimbangkan':
                                        $status = '<span class="label label-danger">DITOLAK</span>';
                                        break;

                                    default:
                                        $status = '<span class="label label-primary">MENUNGGU TINDAKAN</span>';
                                        break;
                                }
                                return $status;
                            }, 
                                    'format' => 'html',
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
                        return Html::a('<input type="radio" name="'.$data->id.'" value="y'.$data->id.'" '.$checked.'>')
                                ;
                      },
                       
                    ],
            
                              
            
                    [        
                        'class' => 'yii\grid\CheckboxColumn',
                        'checkboxOptions' => function ($data) { 
                        if(($data->status_bsm=='Diluluskan' ||$data->status_bsm=='Tidak Diluluskan')){
                        return ['disabled' => 'disabled'];
                            }
//                            return ['value' => $data->id, 'checked'=> true];
                            },
                     ],
                  

                        ];



                        echo GridView::widget([
                            'dataProvider' => $semaks,
                            'columns' => $gridColumns6,
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
        </div>
    </div> 
    

</div>  
            
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

            [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON',
                     'headerOptions' => ['style' => 'width:40%','class'=>'text-center'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                                
                                
                                 if($model->idBorang == "50") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["tuntutan-yuran/view-tuntutan-yuran",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                            }, 
                                    'format' => 'html',
                        ],        
                                    [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS KEPUTUSAN',
                       'headerOptions' => ['style' => 'width:50%'],
//                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
//                                $ICNO = $model->icno;
                                if($model->status_bsm =="Diluluskan" )
                                {
                                return Html::a($model->statusbsm.'<br><small>'.strtoupper($model->catatan).'</small>');
                                }
                                else
                                {
                                    echo '-';
                                }
                            }, 
                                    'format' => 'html',
                        ], 
                                    
                                    
                                    
//                                    [
//                        'label'=>'KEMASKINI KEPUTUSAN',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                        'value'=>function ($data) {
//                       
//                        if($data->terima == NULL){
//                        $ICNO = $data->icno;
//                        
//                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['cbadmin/tindakanbsm_akhir', 'id' => $data->id]),'style'=>'background-color: transparent; 
//                        border: none;', 'class' => 'fa fa-edit fa-lg mapBtn']);}
////                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]);}
//                        else{
//                            return Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO ])|  Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
//                        }
//                      },
//                           
//                    ],
                              [
                            'class' => 'yii\grid\ActionColumn',
                           //'attribute' => 'CONm',
                            'header' => 'KEMASKINI KEPUTUSAN',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'template' => '{update}',
                            //'header' => 'TINDAKAN',
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    $url = Url::to(['cbadmin/tindakanbsm_akhir', 'id' => $model->id]);
                                    return Html::button('<i class="fa fa-pencil fa-lg"></i>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                    
                                },
                            ],
                        ],
            
                              
            
//                    [        
//                        'class' => 'yii\grid\CheckboxColumn',
//                        'checkboxOptions' => function ($data) { 
//                        if(($data->status_bsm=='Diluluskan' ||$data->status_bsm=='Tidak Diluluskan')){
//                        return ['disabled' => 'disabled'];
//                            }
//                            return ['value' => $data->id, 'checked'=> true];
//                            },
//                     ],
//                  

                        ];



                        echo GridView::widget([
                            'dataProvider' => $luluss,
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
                                . '<i class="fa fa-check-square fa-lg" style="color:green"></i> Telah Diluluskan Bahagian Sumber Manusia</h6>',
                            ],
                        ]);
                        ?>
            </div>


        </div>
    </div>  

</div> 
        
             <div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel"> 


            <div class="table-responsive">

                <?php
                $gridColumns5 = [
                    ['class' => 'yii\grid\SerialColumn', 
                     'header' => 'BIL',
                     'headerOptions' => ['style' => 'width:1%','class'=>'text-center'],
                     'contentOptions' => ['class'=>'text-center'],

                       ],

            [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON',
                     'headerOptions' => ['style' => 'width:40%','class'=>'text-center'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                              
                                 if($model->idBorang == "50") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["tuntutan-ielts/view-tuntutan-ielts",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                            }, 
                                    'format' => 'html',
                        ],        
                                    [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS KEPUTUSAN',
                       'headerOptions' => ['style' => 'width:50%'],
//                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
//                                $ICNO = $model->icno;
                                if($model->status_bsm =="Tidak Diluluskan")
                                {
                                return Html::a($model->statusbsm.'<br><small>'.strtoupper($model->catatan).'</small>');
                                }
                                else
                                {
                                    echo '-';
                                }
                            }, 
                                    'format' => 'html',
                        ], 
                                    
                                    
                                    
//                                    [
//                        'label'=>'KEMASKINI KEPUTUSAN',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                        'value'=>function ($data) {
//                       
//                        if($data->terima == NULL){
//                        $ICNO = $data->icno;
//                        
//                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['cbadmin/tindakanbsm_akhir', 'id' => $data->id]),'style'=>'background-color: transparent; 
//                        border: none;', 'class' => 'fa fa-edit fa-lg mapBtn']);}
////                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]);}
//                        else{
//                            return Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO ])|  Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
//                        }
//                      },
//                           
//                    ],
                              [
                            'class' => 'yii\grid\ActionColumn',
                           //'attribute' => 'CONm',
                            'header' => 'KEMASKINI KEPUTUSAN',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'template' => '{update}',
                            //'header' => 'TINDAKAN',
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    $url = Url::to(['cbadmin/tindakanbsm_akhir', 'id' => $model->id]);
                                    return Html::button('<i class="fa fa-pencil fa-lg"></i>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                    
                                },
                            ],
                        ],
            
                              
            
//                    [        
//                        'class' => 'yii\grid\CheckboxColumn',
//                        'checkboxOptions' => function ($data) { 
//                        if(($data->status_bsm=='Diluluskan' ||$data->status_bsm=='Tidak Diluluskan')){
//                        return ['disabled' => 'disabled'];
//                            }
//                            return ['value' => $data->id, 'checked'=> true];
//                            },
//                     ],
//                  

                        ];



                        echo GridView::widget([
                            'dataProvider' => $tolaks,
                            'columns' => $gridColumns5,
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
                                . '<i class="fa fa-times fa-lg" style="color:red"></i> Tidak Diluluskan Bahagian Sumber Manusia</h6>',
                            ],
                        ]);
                        ?>
            </div>


        </div>
    </div>  

</div>
</div>
        
<div role="tabpanel" class="tab-pane fade" id="tab_content6" aria-labelledby="profile-tab">
       
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel"> 


            <div class="table-responsive">

                <?php
                $gridColumns6 = [
                    ['class' => 'yii\grid\SerialColumn', 
                     'header' => 'BIL',
                     'headerOptions' => ['style' => 'width:1%','class'=>'text-center'],
                     'contentOptions' => ['class'=>'text-center'],

                       ],
                      [
                           //'attribute' => 'CONm',
                            'label' => 'JENIS TUNTUTAN ',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                             
                                switch ($model->j_tuntutan) {
                                    case 'VISA':
                                        $status = '<span class="label label-success"> VISA </span>';
                                        break;
                                    case 'INSURANS':
                                        $status = '<span class="label label-warning">INSURANS</span>';
                                        break;

                                    default:
                                        $status = '<span class="label label-primary">TIDAK DIKETAHUI</span>';
                                        break;
                                }
                                return $status;
                            }, 
                                    'format' => 'html',
                        ],
            [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                             
                                if($model->idBorang == "52") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["tuntutan-visa/view-tuntutan-visa",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                                    if($model->idBorang == "53") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["tuntutan-insurans/view-tuntutan-insurans",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                            }, 
                                    'format' => 'html',
                        ],  
                                    [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS SEMAKAN',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                             
                                switch ($model->status_semakan) {
                                    case 'Layak Dipertimbangkan':
                                        $status = '<span class="label label-success"> DIPROSES </span>';
                                        break;
                                    case 'Tidak Layak Dipertimbangkan':
                                        $status = '<span class="label label-danger">DITOLAK</span>';
                                        break;

                                    default:
                                        $status = '<span class="label label-primary">MENUNGGU TINDAKAN</span>';
                                        break;
                                }
                                return $status;
                            }, 
                                    'format' => 'html',
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
                        return Html::a('<input type="radio" name="'.$data->id.'" value="y'.$data->id.'" '.$checked.'>')
                                ;
                      },
                       
                    ],
            
                              
            
                    [        
                        'class' => 'yii\grid\CheckboxColumn',
                        'checkboxOptions' => function ($data) { 
                        if(($data->status_bsm=='Diluluskan' ||$data->status_bsm=='Tidak Diluluskan')){
                        return ['disabled' => 'disabled'];
                            }
//                            return ['value' => $data->id, 'checked'=> true];
                            },
                     ],
                  

                        ];



                        echo GridView::widget([
                            'dataProvider' => $semakv,
                            'columns' => $gridColumns6,
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
        </div>
    </div> 
    

</div>  
            
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
  [
                           //'attribute' => 'CONm',
                            'label' => 'JENIS TUNTUTAN ',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                             
                                switch ($model->j_tuntutan) {
                                    case 'VISA':
                                        $status = '<span class="label label-success"> VISA </span>';
                                        break;
                                    case 'INSURANS':
                                        $status = '<span class="label label-warning">INSURANS</span>';
                                        break;

                                    default:
                                        $status = '<span class="label label-primary">TIDAK DIKETAHUI</span>';
                                        break;
                                }
                                return $status;
                            }, 
                                    'format' => 'html',
                        ],
            [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON',
                     'headerOptions' => ['style' => 'width:40%','class'=>'text-center'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                                
                                
                                 if($model->idBorang == "52") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["tuntutan-visa/view-tuntutan-visa",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                                if($model->idBorang == "53") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["tuntutan-insurans/view-tuntutan-insurans",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                            }, 
                                    'format' => 'html',
                        ],        
                                    [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS KEPUTUSAN',
                       'headerOptions' => ['style' => 'width:50%'],
//                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
//                                $ICNO = $model->icno;
                                if($model->status_bsm =="Diluluskan" )
                                {
                                return Html::a($model->statusbsm.'<br><small>'.strtoupper($model->catatan).'</small>');
                                }
                                else
                                {
                                    echo '-';
                                }
                            }, 
                                    'format' => 'html',
                        ], 
                                    
                                    
                                    
//                                    [
//                        'label'=>'KEMASKINI KEPUTUSAN',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                        'value'=>function ($data) {
//                       
//                        if($data->terima == NULL){
//                        $ICNO = $data->icno;
//                        
//                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['cbadmin/tindakanbsm_akhir', 'id' => $data->id]),'style'=>'background-color: transparent; 
//                        border: none;', 'class' => 'fa fa-edit fa-lg mapBtn']);}
////                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]);}
//                        else{
//                            return Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO ])|  Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
//                        }
//                      },
//                           
//                    ],
                              [
                            'class' => 'yii\grid\ActionColumn',
                           //'attribute' => 'CONm',
                            'header' => 'KEMASKINI KEPUTUSAN',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'template' => '{update}',
                            //'header' => 'TINDAKAN',
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    $url = Url::to(['cbadmin/tindakanbsm_akhir', 'id' => $model->id]);
                                    return Html::button('<i class="fa fa-pencil fa-lg"></i>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                    
                                },
                            ],
                        ],
            
                              
            
//                    [        
//                        'class' => 'yii\grid\CheckboxColumn',
//                        'checkboxOptions' => function ($data) { 
//                        if(($data->status_bsm=='Diluluskan' ||$data->status_bsm=='Tidak Diluluskan')){
//                        return ['disabled' => 'disabled'];
//                            }
//                            return ['value' => $data->id, 'checked'=> true];
//                            },
//                     ],
//                  

                        ];



                        echo GridView::widget([
                            'dataProvider' => $lulusv,
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
                                . '<i class="fa fa-check-square fa-lg" style="color:green"></i> Telah Diluluskan Bahagian Sumber Manusia</h6>',
                            ],
                        ]);
                        ?>
            </div>


        </div>
    </div>  

</div> 
        
             <div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel"> 


            <div class="table-responsive">

                <?php
                $gridColumns5 = [
                    ['class' => 'yii\grid\SerialColumn', 
                     'header' => 'BIL',
                     'headerOptions' => ['style' => 'width:1%','class'=>'text-center'],
                     'contentOptions' => ['class'=>'text-center'],

                       ],
                      [
                           //'attribute' => 'CONm',
                            'label' => 'JENIS TUNTUTAN ',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                             
                                switch ($model->j_tuntutan) {
                                    case 'VISA':
                                        $status = '<span class="label label-success"> VISA </span>';
                                        break;
                                    case 'INSURANS':
                                        $status = '<span class="label label-warning">INSURANS</span>';
                                        break;

                                    default:
                                        $status = '<span class="label label-primary">TIDAK DIKETAHUI</span>';
                                        break;
                                }
                                return $status;
                            }, 
                                    'format' => 'html',
                        ],

            [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON',
                     'headerOptions' => ['style' => 'width:40%','class'=>'text-center'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                              
                                 if($model->idBorang == "52") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["tuntutan-ielts/view-tuntutan-ielts",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                                  if($model->idBorang == "53") 
                                {
                                     return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["tuntutan-insurans/view-tuntutan-insurans",  'id'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_m;
                                }
                            }, 
                                    'format' => 'html',
                        ],        
                                    [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS KEPUTUSAN',
                       'headerOptions' => ['style' => 'width:50%'],
//                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
//                                $ICNO = $model->icno;
                                if($model->status_bsm =="Tidak Diluluskan")
                                {
                                return Html::a($model->statusbsm.'<br><small>'.strtoupper($model->catatan).'</small>');
                                }
                                else
                                {
                                    echo '-';
                                }
                            }, 
                                    'format' => 'html',
                        ], 
                                    
                                    
                                    
//                                    [
//                        'label'=>'KEMASKINI KEPUTUSAN',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                        'value'=>function ($data) {
//                       
//                        if($data->terima == NULL){
//                        $ICNO = $data->icno;
//                        
//                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['cbadmin/tindakanbsm_akhir', 'id' => $data->id]),'style'=>'background-color: transparent; 
//                        border: none;', 'class' => 'fa fa-edit fa-lg mapBtn']);}
////                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]);}
//                        else{
//                            return Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO ])|  Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
//                        }
//                      },
//                           
//                    ],
                              [
                            'class' => 'yii\grid\ActionColumn',
                           //'attribute' => 'CONm',
                            'header' => 'KEMASKINI KEPUTUSAN',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'template' => '{update}',
                            //'header' => 'TINDAKAN',
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    $url = Url::to(['cbadmin/tindakanbsm_akhir', 'id' => $model->id]);
                                    return Html::button('<i class="fa fa-pencil fa-lg"></i>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                    
                                },
                            ],
                        ],
            
                              
            
//                    [        
//                        'class' => 'yii\grid\CheckboxColumn',
//                        'checkboxOptions' => function ($data) { 
//                        if(($data->status_bsm=='Diluluskan' ||$data->status_bsm=='Tidak Diluluskan')){
//                        return ['disabled' => 'disabled'];
//                            }
//                            return ['value' => $data->id, 'checked'=> true];
//                            },
//                     ],
//                  

                        ];



                        echo GridView::widget([
                            'dataProvider' => $tolakv,
                            'columns' => $gridColumns5,
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
                                . '<i class="fa fa-times fa-lg" style="color:red"></i> Tidak Diluluskan Bahagian Sumber Manusia</h6>',
                            ],
                        ]);
                        ?>
            </div>


        </div>
    </div>  

</div>
</div>


 
</div>
</div>      <?php ActiveForm::end(); ?>
