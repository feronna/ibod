<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;

error_reporting(0);
?>
 <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true"><b>Permohonan Baharu</b></a>
                </li>
                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><b>Telah Diluluskan</b></a>
                </li>
            
               <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"><b>Telah Ditolak</b></a>
                </li>
                
                 <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false"><b>KIV</b></a>
                </li>
                
            </ul>
        </div>
     <div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tab_content1" aria-labelledby="home-tab">
<?php if($title == 'Senarai Menunggu Semakan'){?>
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

<div class="row"> 
     <div class="col-xs-12 col-md-12 col-lg-12"> 
    
        <div class="x_content">
            <div class="table-responsive">
             <?= GridView::widget([
        'dataProvider' => $senarai,
        'summary' => '',
        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                 'options' => [
                'class' => 'table-responsive',
                    ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                                'header' => 'Bil',
            ],
            [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON',
                            'headerOptions' => ['class'=>'column-title'],
                            
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                                return Html::a( '<br><strong><small>PELANJUTAN KALI:</strong></small> '. $model->idlanjutan. '<br>'.'<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lanjutancb/adminview", 'id' => $model->iklan_id, 'i'=>$model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. 
                                       
                                        '<small><br>Tarikh Mohon:'. $model->tarikhmohon.'</small>';
                            }, 
                                    'format' => 'html',
                        ],
                                     [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS KETUA JABATAN/DEKAN',
                        'headerOptions' => ['class'=>'text-center'],
                             'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->id;
                                return '<strong>'.$model->statusjfpiu.'</strong><br>'
                                        .$model->app_date;
                            }, 
                                    'format' => 'html',
                                    
                                    
                        ],
                                    [
//                     'attribute' => 'status_jfpiu',
                        'label' => 'SEMAKAN PERMOHONAN',
                        'headerOptions' => ['class'=>'text-center'],
                        'contentOptions' => ['class'=>'text-center'],
                        'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->id;
                                return '<strong>'.$model->statussemakan.'</strong><br>'
                                        .$model->c_date;
                            }, 
                        'format' => 'raw',
                      
                    ],
            [
                        'label'=>'RINGKASAN KEPUTUSAN',
                        'format' => 'raw',
                        'headerOptions' => ['class'=>'text-center'],
                        'contentOptions' => ['class'=>'text-center'],
                        'value'=>function ($data) {
                       
                        if($data->terima == NULL){
                        $ICNO = $data->icno;
                        
                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['tindakan_bsm', 'id' => $data->id]),'style'=>'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-edit fa-lg mapBtn']);}
//                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]);}
                        else{
                            return Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO ])|  Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
                        }
                      },
                           
                    ],
                              
                     [
                        'label'=>'SURAT KELULUSAN',
                        'format' => 'raw',
                        'headerOptions' => ['class'=>'text-center'],
                        'contentOptions' => ['class'=>'text-center'],
                        'value'=>function ($data) {
//                         if ($data->checkUploadlanjut($data->id)){
//                         return  Html::a('Klik', 
//                        (Yii::$app->FileManager->DisplayFile($data-->dokumen)), ['class'=>'fa fa-check-square-o fa-lg', 'target' => '_blank']);}
//                        else{
                          return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['uploadsuratlanjut', 'id' => $data->id]),'style'=>'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-upload fa-lg mapBtn']);
                        }
                     
             ],
//                              [
//                        'label'=>'SALINAN SURAT TAWARAN',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                       'value'=>function ($data)  {
//                         if ($data->checkUploadlanjutan($data->id)){
//                         return  Html::a('', 
//                            (Yii::$app->FileManager->DisplayFile($data->dokumen->dokumen)), 
//                            ['class'=>'fa fa-check-square-o fa-lg', 'target' => '_blank']);}
//                        else{
//                          return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['uploadsuratlain', 'id' => $data->id]),'style'=>'background-color: transparent; 
//                        border: none;', 'class' => 'fa fa-upload fa-lg mapBtn']);
//                        }
//                      },
//             ],
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
                        if($data->status_bsm == 'Diluluskan' || $data->status_bsm == 'Tidak Diluluskan' || $data->status_bsm == 'KIV'){
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
            
        ],
    ]); ?>
    </div>
        </div>
          <div class="col-md-12 col-sm-12 col-xs-12" align="right">  
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['class' => 'btn btn-primary', 'name' => 'hantar', 'value' => 'submit_2']) ?>
                </div>
      <?php ActiveForm::end(); ?>
    </div>
</div></div><?php }?>
<div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

       
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel"> 


            <div class="table-responsive">

                <?php
                $gridColumns2 = [
                    ['class' => 'yii\grid\SerialColumn', 
                     'header' => 'BIL',
                     'headerOptions' => ['style' => 'width:1%','class'=>'text-center'],
                     'contentOptions' => ['class'=>'text-center'],

                       ],
                    [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON ',
                            'headerOptions' => ['style' => 'width:20%','class'=>'text-left'],
//                               'filter' => Select2::widget([
//                            'name' => 'icno',
//                            'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
//                            'data' => ArrayHelper::map(\app\models\cbelajar\TblPermohonan::find()->all(), 'icno', 'kakitangan.CONm'),
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                            ],
//                        ]),
                           'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                                
                                
                          
                           
                        $ICNO = $model->icno;
                        return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ['lanjutancb/adminview',  'id' => $model->iklan_id, 'i'=>$id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon: '. $model->tarikhmohon;
                       
                        },
                          
                                    'format' => 'html',
                        ],
          
                                    [
                           //'attribute' => 'CONm',
                            'label' => 'MAKLUMAT PELANJUTAN',
                            'headerOptions' => ['style' => 'width:20%','class'=>'text-left'],
//                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
                    if($model->lanjutansdt)
                    {
                                return Html::a(
                                           '<small><strong>PELANJUTAN KALI:</strong></small> '. $model->idlanjutan. '<br>'.
                                     '<small><strong>CATATAN URUSETIA:</strong> '.strtoupper($model->catatan_bsm).'<br></small>'.
                                     '<small><strong>TARIKH PELANJUTAN: </strong>'.strtoupper($model->stlanjutan).' HINGGA '.
                                     strtoupper($model->ndlanjutan).' ('.$model->tempohlanjutan.')</small>')
                              ;
                                   
                            }
                            else{
                                return '-';
                            }
                    }, 
                                    'format' => 'html',
                        ],   
//                           [
//                        'label'=>'SURAT KELULUSAN',
//                        'format' => 'raw',
//                            'headerOptions' => ['class'=>'text-center'],
//                            'contentOptions' => ['class'=>'text-center'],       
//                        'value'=>function ($data)  {
//                        if($data->status_bsm == 'Diluluskan' || $data->status_bsm == 'Tidak Diluluskan'){
//                           
//                            return  Html::a('', (Yii::$app->FileManager->DisplayFile($data->dokumen->dokumen)), ['class'=>'fa fa-download', 'target' => '_blank']);
//
//                            } else {
//                               return '<i class="fa  fa-times fa-xs style="color:black;"></i> ';
//                            }
//                      },
//             ],
                [
                        'label'=>'SURAT KELULUSAN',
                        'format' => 'raw',
                            'headerOptions' => ['style' => 'width:2%','class'=>'text-left'],
                        'contentOptions' => ['class'=>'text-center'],
                        'value'=>function ($data) {
//                         if ($data->checkUploadlanjut($data->id)){
//                         return  Html::a('Klik', 
//                        (Yii::$app->FileManager->DisplayFile($data-->dokumen)), ['class'=>'fa fa-check-square-o fa-lg', 'target' => '_blank']);}
//                        else{
                          return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['uploadsuratlanjut', 'id' => $data->id]),'style'=>'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-upload fa-lg mapBtn']);
                        }
                     
             ],
//                           
                  

                        ];



                        echo GridView::widget([
                            'dataProvider' => $lulus,
                            'columns' => $gridColumns2,
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
                                . '<i class="fa fa-check-square fa-lg" style="color:green"></i> Permohonan Yang Diluluskan Jawatankuasa Pengajian Lanjutan</h6>',
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
                            'label' => 'NAMA PEMOHON ',
                            'headerOptions' => ['style' => 'width:20%','class'=>'text-left'],
//                               'filter' => Select2::widget([
//                            'name' => 'icno',
//                            'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
//                            'data' => ArrayHelper::map(\app\models\cbelajar\TblPermohonan::find()->all(), 'icno', 'kakitangan.CONm'),
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                            ],
//                        ]),
                           'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                                
                                
                          
                           
                        $ICNO = $model->icno;
                        return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ['lanjutancb/adminview',  'id' => $model->iklan_id, 'i'=>$id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon: '. $model->tarikhmohon;
                       
                        },
                          
                                    'format' => 'html',
                        ],
          
                                    [
                           //'attribute' => 'CONm',
                            'label' => 'MAKLUMAT PELANJUTAN',
                            'headerOptions' => ['style' => 'width:20%','class'=>'text-left'],
//                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
                    if($model->lanjutansdt)
                    {
                                return Html::a(
                                           '<small><strong>PELANJUTAN KALI:</strong></small> '. $model->idlanjutan. '<br>'.
                                     '<small><strong>CATATAN URUSETIA:</strong> '.strtoupper($model->catatan_bsm).'<br></small>'.
                                     '<small><strong>TARIKH PELANJUTAN: </strong>'.strtoupper($model->stlanjutan).' HINGGA '.
                                     strtoupper($model->ndlanjutan).' ('.$model->tempohlanjutan.')</small>')
                              ;
                                   
                            }
                            else{
                                return '-';
                            }
                    }, 
                                    'format' => 'html',
                        ],    
                  

                        ];



                        echo GridView::widget([
                            'dataProvider' => $tolak,
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
                                . '<i class="fa fa-times fa-lg" style="color:red"></i> Permohonan Yang Ditolak Jawatankuasa Pengajian Lanjutan</h6>',
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
                $gridColumns3 = [
                    ['class' => 'yii\grid\SerialColumn', 
                     'header' => 'BIL',
                     'headerOptions' => ['style' => 'width:1%','class'=>'text-center'],
                     'contentOptions' => ['class'=>'text-center'],

                       ],
                    [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA PEMOHON ',
                            'headerOptions' => ['style' => 'width:20%','class'=>'text-left'],
//                               'filter' => Select2::widget([
//                            'name' => 'icno',
//                            'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
//                            'data' => ArrayHelper::map(\app\models\cbelajar\TblPermohonan::find()->all(), 'icno', 'kakitangan.CONm'),
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                            ],
//                        ]),
                           'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                                
                                
                          
                           
                        $ICNO = $model->icno;
                        return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ['lanjutancb/adminview',  'id' => $model->iklan_id, 'i'=>$id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon: '. $model->tarikhmohon;
                       
                        },
                          
                                    'format' => 'html',
                        ],
          
                                    [
                           //'attribute' => 'CONm',
                            'label' => 'MAKLUMAT PELANJUTAN',
                            'headerOptions' => ['style' => 'width:20%','class'=>'text-left'],
//                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
                    if($model->lanjutansdt)
                    {
                                return Html::a(
                                           '<small><strong>PELANJUTAN KALI:</strong></small> '. $model->idlanjutan. '<br>'.
                                     '<small><strong>CATATAN URUSETIA:</strong> '.strtoupper($model->catatan_bsm).'<br></small>'.
                                     '<small><strong>TARIKH PELANJUTAN: </strong>'.strtoupper($model->stlanjutan).' HINGGA '.
                                     strtoupper($model->ndlanjutan).' ('.$model->tempohlanjutan.')</small>')
                              ;
                                   
                            }
                            else{
                                return '-';
                            }
                    }, 
                                    'format' => 'html',
                        ],    
                  [
                        'label'=>'SURAT PEMAKLUMAN',
                        'format' => 'raw',
                            'headerOptions' => ['style' => 'width:2%','class'=>'text-left'],
                        'contentOptions' => ['class'=>'text-center'],
                        'value'=>function ($data) {
//                         if ($data->checkUploadlanjut($data->id)){
//                         return  Html::a('Klik', 
//                        (Yii::$app->FileManager->DisplayFile($data-->dokumen)), ['class'=>'fa fa-check-square-o fa-lg', 'target' => '_blank']);}
//                        else{
                          return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['uploadsuratlanjut', 'id' => $data->id]),'style'=>'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-upload fa-lg mapBtn']);
                        }
                     
             ],

                        ];



                        echo GridView::widget([
                            'dataProvider' => $kiv,
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
                                . '<i class="fa fa-eye fa-lg" style="color:purple"></i> Keep In View (KIV)</h6>',
                            ],
                        ]);
                        ?>
            </div>


        </div>
    </div>  

</div>  
</div>
<?php if($title == 'Senarai Menunggu Perakuan'){?>
<div class="row"> 
     <div class="col-xs-12 col-md-12 col-lg-12"> 
    
        <div class="x_content">
            <div class="table-responsive">
             <?= GridView::widget([
        'dataProvider' => $senarai,
        'summary' => '',
        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                 'options' => [
                'class' => 'table-responsive',
                    ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                                'header' => 'Bil',
                                ],
           [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA ',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>').'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred;
                            }, 
                                    'format' => 'html',
                        ],
                                    [
                'label' => 'TARIKH MOHON',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>'tarikh_mohon',
            ],
              
           
//           [
//                'label' => 'STATUS PERAKUAN KETUA JFPIB',
//                'format' => 'raw',
//                'headerOptions' => ['class'=>'text-center'],
//                                'contentOptions' => ['class'=>'text-center'],
//                'value'=>'statusjfpiu',
//            ],
                                    [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS KETUA JABATAN/DEKAN',
                            'headerOptions' => ['class'=>'text-center'],
                             'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->id;
                                return '<strong>'.$model->statusjfpiu.'</strong><br>'
                                        .$model->app_date;
                            }, 
                                    'format' => 'html',
                                    
                                    
                        ],
                                   [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS BSM',
                            'headerOptions' => ['class'=>'text-center'],
                             'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->id;
                                return '<strong>'.$model->statusbsm.'</strong><br>'
                                        .$model->ver_date;
                            }, 
                                    'format' => 'html',
                                    
                                    
                        ],
//              [
//                        'label'=>'SURAT KELULUSAN',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                        'value'=>function ($data) {
//                         if ($data->checkUpload($data->id)){
//                         return  Html::a('', (Yii::$app->FileManager->DisplayFile($data->dokumen->dokumen)), ['class'=>'fa fa-check-square-o fa-lg', 'target' => '_blank']);}
//                        else{
//                          return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['uploadsuratlain', 'id' => $data->id]),'style'=>'background-color: transparent; 
//                        border: none;', 'class' => 'fa fa-upload fa-lg mapBtn']);
//                        }
//                      },
//             ],
//                              [
//                        'label'=>'SURAT KELULUSAN',
//                        'format' => 'raw',
//                            'headerOptions' => ['class'=>'text-center'],
//                            'contentOptions' => ['class'=>'text-center'],       
//                        'value'=>function ($data)  {
//                        if($data->status_bsm == 'Diluluskan' || $data->status_bsm == 'Tidak Diluluskan'){
//                           
//                            return  Html::a('', (Yii::$app->FileManager->DisplayFile($data->dokumen->dokumen)), ['class'=>'fa fa-download', 'target' => '_blank']);
//
//                            } else {
//                               return '<i class="fa  fa-times fa-xs style="color:black;"></i> ';
//                            }
//                      },
//             ],
//                [
//                        'label'=>'SURAT KELULUSAN',
//                        'format' => 'raw',
//                            'headerOptions' => ['class'=>'text-center'],
//                            'contentOptions' => ['class'=>'text-center'],       
//                        'value'=>function ($data)  {
////                        if($data->status_bsm == 'Diluluskan' || $data->status_bsm == 'Tidak Diluluskan'){
//                           if($data->dokumen->dokumen)
//                           {
//                            return  Html::a('', (Yii::$app->FileManager->DisplayFile($data->dokumen->dokumen)), ['class'=>'fa fa-download', 'target' => '_blank']);
//                           }
//                             else {
//                               return '<i class="fa  fa-times fa-xs style="color:black;"></i> ';
//                            }
//                        }   ,
//             ],
            [
                'label' => 'TINDAKAN',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>function ($list) use ($iklan){
                            if($list->status_jfpiu === 'Tunggu Kelulusan'){
                        return  
                        Html::a('<i class="fa fa-edit">', ["tindakankj", 'id' => $list->id]);
                            }
                            else{
                        return Html::a('<i class="fa fa-edit">', ["tindakan-kj", 'id' => $list->iklan_id, 'i'=>$list->id]);
                            }
                        
                      },
            ],
                              
            
        ],
    ]); ?>
    </div>
        </div>
     
    </div>
</div><?php }?>
</div>
 </div>