<?php

use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
error_reporting(0);
use kartik\export\ExportMenu;
?>

<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/memorandum/_menu');?> 
</div>

<div class="row">
 <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                </ul>
                <div class="clearfix"></div>
              
            </div>
            <div class="x_content">
                
                <?php
                $form = ActiveForm::begin([
                    'action' => ['halaman-kj'],
                    'method' => 'get',
                    'options' => [
                        'data-pjax' => 1
                    ],
                ]);
                ?>
  
              
                  <?= $form->field($searchModel, 'carian_bil')->textInput(['placeholder' => 'Carian Bil.JPU','style'=>'width:100%'])->label(false) ?> 

                
                  <?= $form->field($searchModel, 'carian_perkara')->textInput(['placeholder' => 'Carian Perkara/Minit','style'=>'width:100%'])->label(false) ?> 

     
                
                 <?= $form->field($searchModel, 'carian_tahun')->textInput(['placeholder' => 'Carian Tahun','style'=>'width:100%'])->label(false) ?> 

                        <?=
                            $form->field($searchModel, 'carian_status')->label(false)->widget(Select2::classname(), [
                         //   'data' => ArrayHelper::map(Kumpulankhidmat::find()->all(), 'id', 'name'),
                              'data' => [1 => 'SELESAI', 0 => 'BELUM SELESAI'],
                             'options' => ['placeholder' => 'Carian Status Index', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                                ],
                            ]);
                            ?> 
        
                
                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-microchip"></i> Search', ['class' => 'btn btn-primary']) ?>
                  
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            </div>
        </div>
    </div>


<div class="row">
<div class="col-md-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2>Senarai Memorandum</h2> <?= $biodata->shortname ?>
        
            <div class="clearfix"></div>
        </div>
           
                
                
      
                <?php
            echo ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'clearBuffers' => true,
                'columns' => [
                    [
                        'class' => 'kartik\grid\SerialColumn',
                        'headerOptions' => [
                            'style' => 'display: none;',
                        ]
                    ],
                    
                     [
                     'headerOptions' => ['style' => 'width:10%', 'class' => 'text-center'],
                        'label' => 'TAHUN',
                        'value' => 'tblRekod.tahun',
                        'hAlign' => 'left',
                      
                    ],
                    
                  
                    
                     [
                       'headerOptions' => ['style' => 'width:10%', 'class' => 'text-center'],
                        'label' => 'BIL JPU',
                        'format' => 'raw',
                         'value' => function ($data) {
                      return  strtoupper($data->tblRekod->bil_jpu). "Kali Ke-". strtoupper($data->tblRekod->kali_ke);
                        },
                        'hAlign' => 'left',
                    ],
                                
                    [
                     'headerOptions' => ['style' => 'width:60%', 'class' => 'text-center'],
                         'format' => 'raw',
                        'label' => 'PERKARA / MINIT',
                        'value' => 'tblRekod.perkara',
                             'hAlign' => 'left',
                      
                    ],
                    
                                
                                     [
                     'headerOptions' => ['style' => 'width:5%', 'class' => 'text-center'],
                        'label' => 'JAFPIB',
                        'value' => 'department.shortname',
                        'hAlign' => 'left',
                      
                    ],
                                
                    [
                        'label' => 'MAKLUMBALAS JAFPIB',
                        'headerOptions' => ['style' => 'width:30%', 'class' => 'text-center'],
                       'format' => 'raw',
                            
                       'value' => function ($data) {
                 $list = [1 => '<span class="label label-success">DIPERAKUKAN</span>', 0 => '<span class="label label-danger">BELUM DIPERAKUKAN</span>',];             
                         if($data->id_rekod != null){
                         return $data->maklumbalas_ptj.'<br>'.
                                 
                           Html::a(''  . $data->doc_name, Url::to('https://mediahost.ums.edu.my/api/v1/viewFile/' . $data->hashcode, $schema = true), ['target' => '_blank', 'style' =>  'text-decoration: underline; color:green' ]).
                              '<br>'.'<br>'.
                              '<strong>'.'Urusetia JAFPIB :'. '<br>'.$data->kakitangan->CONm.
                                 '<br>'.$data->department->shortname.'<br>'.$data->tarikhMaklumbalas. '</strong>'.
                                 '<br>'.'<br>'.'<br>'.  $list[$data->status_kj].
                                          '<br>'.'<br>'.
                                 
                                '<strong>'. 'Pegawai Peraku:'.'<br>'. $data->pegawaiPeraku->CONm.
                                 '<br>'.$data->department->shortname.'<br>'.$data->tarikhPerakuan.'</strong>';
                }else{
                    return 'TIADA MAKLUMBALAS';
                }
                    }
         
        ],
                
                
                   [
                        'label' => 'MAKLUMBALAS URUSETIA',
                        'headerOptions' => ['style' => 'width:30%', 'class' => 'text-center'],
                        'format' => 'raw',
                                     'hAlign' => 'left',
                         'value' => function ($data) {
                if($data->tblRekod->tblMaklumbalas != null){
                         return Html::a($data->tblRekod->tblMaklumbalas->TugasUtama($data->tblRekod->tblMaklumbalas->id) ).'<br>'.
                              Html::a(''  . $data->tblRekod->tblMaklumbalas->doc_name, Url::to('https://mediahost.ums.edu.my/api/v1/viewFile/' . $data->tblRekod->tblMaklumbalas->hashcode, $schema = true), ['target' => '_blank', 'style' =>  'text-decoration: underline; color:green' ]).
                     '<br>'.'<br>'.
                              '<strong>'.'Urus Setia JPU :'. '<br>'.$data->tblRekod->tblMaklumbalas->kakitangan->CONm.
                                 '<br>'.$data->tblRekod->tblMaklumbalas->department->shortname. '<br>'.$data->tblRekod->tblMaklumbalas->tarikhMaklumbalas. '</strong>'.
                                 '<br>'.'</strong>'.'<br>';
                }else{
                    return 'TIADA MAKLUMBALAS';
                }
                    }
         
        ],
       
       
                 [
                        'label' => 'STATUS INDEX',
                        'headerOptions' => ['style' => 'width:30%', 'class' => 'text-center'],
                        'format' => 'raw',
                         'value' => function ($data) {
             $list = [1 => '<span class="label label-success">SELESAI</span>', 0 => '<span class="label label-danger">BELUM SELESAI</span>',];                 
             if($data->tblRekod->status == 1){
                   return $list[$data->tblRekod->status] ; 
             }else{
                    return $list[$data->tblRekod->status] ; 
             }
                      
                    },
                         'hAlign' => 'left',
         
        ],
                              
               
                ],
//                'exportConfig' => [ // set styling for your custom dropdown list items
//                    ExportMenu::FORMAT_CSV => false,
//                    ExportMenu::FORMAT_TEXT => false,
//                    ExportMenu::FORMAT_HTML => false,
//                    ExportMenu::FORMAT_PDF => false,
//                    ExportMenu::FORMAT_EXCEL => false,
//                    ExportMenu::FORMAT_EXCEL_X =>
//                        [
//                            'options' => ['style' => 'float: right; font-size:18px;'],
//                            'label' => 'Muat turun',
//                            'fontAwesome' => true,
//                            'icon' => ['class'=>'fa fa-download'],
//                            'config' => [
//                                'methods' => [
//                                    'SetHeader' => ['E-memorandum'],
//                                ]
//                            ],
//                        ],
//
//                ],
            //    'showConfirmAlert' => FALSE,
                'filename' => 'Senarai Memorandum',
             //   'asDropdown' => false,
            ]);
                        
            ?>
           <div class="x_content">
        <div class="table-responsive">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                  [
                     'headerOptions' => ['style' => 'width:5%', 'class' => 'text-center'],
                        'label' => 'TAHUN',
                        'value' => 'tblRekod.tahun',
                        'hAlign' => 'left',
                      
                    ],
                  
                    
                     [
                       'headerOptions' => ['style' => 'width:10%', 'class' => 'text-center'],
                        'label' => 'BIL JPU',
                        'format' => 'raw',
                         'value' => function ($data) {
                        return  strtoupper($data->tblRekod->bil_jpu). '&nbsp'. "Kali Ke-". '&nbsp'.strtoupper($data->tblRekod->kali_ke);
                        },
                        'hAlign' => 'left',
                      
                    ],
                    
                                
//                          [
//                     'headerOptions' => ['style' => 'width:60%', 'class' => 'text-center'],
//                        'format' => 'raw',
//                'label' => 'PERKARA / MINIT',
//               'value' => function ($model) {
// 
//                if ($model->tblRekod->doc_name) {
//                    return Html::a($model->tblRekod->perkara).'<br>'.'<br>'.'<br>'.'<br>'.'<strong>'.
//                     Html::a(''  . $model->tblRekod->doc_name, Url::to('https://mediahost.ums.edu.my/api/v1/viewFile/' . $model->tblRekod->hashcode, $schema = true), ['target' => '_blank', 'style' =>  'text-decoration: underline; color:green' ]);
//                } else {
//                    return Html::a($model->tblRekod->perkara).'<br>'.'<br>'.'<br>'.'<br>'.'<strong>'.
//                     'Tiada Lampiran';
//                }
//            }
//                      
//                    ],
                            
             [
                     'headerOptions' => ['style' => 'width:60%', 'class' => 'text-center'],
                        'format' => 'raw',
                'label' => 'PERKARA / MINIT',
               'value' => function ($model) {
 
                if ($model->tblRekod->doc_name) {
                    return $model->tblRekod->perkara.'<br>'.'<br>'.$model->tblPerkara->perkara.'<br>'.'<br>'.'<strong>'.
                     Html::a(''  . $model->tblRekod->doc_name, Url::to('https://mediahost.ums.edu.my/api/v1/viewFile/' . $model->tblRekod->hashcode, $schema = true), ['target' => '_blank', 'style' =>  'text-decoration: underline; color:green' ]);
                } else {
                    return $model->tblRekod->perkara.'<br>'.'<br>'.$model->tblPerkara->perkara.'<br>'.'<br>'.'<strong>'.
                     'Tiada Lampiran';
                }
            }
                      
                    ],
                    
              
//                            [
//                        'label' => 'MAKLUMBALAS JAFPIB',
//                        'headerOptions' => ['style' => 'width:30%', 'class' => 'text-center'],
//                        'format' => 'raw',
//                        'hAlign' => 'left',
//                         'value' => 'maklumbalas_ptj',
//         
//        ],
                                           [
                     'headerOptions' => ['style' => 'width:5%', 'class' => 'text-center'],
                        'label' => 'JAFPIB',
                        'value' => 'department.shortname',
                        'hAlign' => 'left',
                      
                    ],
                            
                            
                         [
                        'label' => 'MAKLUMBALAS JAFPIB',
                        'headerOptions' => ['style' => 'width:30%', 'class' => 'text-center'],
                       'format' => 'raw',
                            
                       'value' => function ($data) {
                 $list = [1 => '<span class="label label-success">DIPERAKUKAN</span>', 0 => '<span class="label label-danger">BELUM DIPERAKUKAN</span>',];             
                         if($data->id_rekod != null){
                         return $data->maklumbalas_ptj.'<br>'.
                                 
                           Html::a(''  . $data->doc_name, Url::to('https://mediahost.ums.edu.my/api/v1/viewFile/' . $data->hashcode, $schema = true), ['target' => '_blank', 'style' =>  'text-decoration: underline; color:green' ]).
                              '<br>'.'<br>'.
                              '<strong>'.'Urusetia JAFPIB :'. '<br>'.$data->kakitangan->CONm.
                                 '<br>'.$data->department->shortname.'<br>'.$data->tarikhMaklumbalas. '</strong>'.
                                 '<br>'.'<br>'.'<br>'.  $list[$data->status_kj].
                                          '<br>'.'<br>'.
                                 
                                '<strong>'. 'Pegawai Peraku:'.'<br>'. $data->pegawaiPeraku->CONm.
                                 '<br>'.$data->department->shortname.'<br>'.$data->tarikhPerakuan.'</strong>';
                }else{
                    return 'TIADA MAKLUMBALAS';
                }
                    }
         
        ],
                            
                  
                            
//                                          [
//                        'label' => 'MAKLUMBALAS JAFPIB',
//                        'headerOptions' => ['style' => 'width:30%', 'class' => 'text-center'],
//                       'format' => 'raw',
//                            
//                       'value' => function ($data) {
//                      if($data->maklumbalas_ptj != null){
//
//                         return  $data->MaklumbalasJafpib($data->id); 
//                 
//                }else{
//                    return 'TIADA MAKLUMBALAS';
//                }
//                    }
//         
//        ],
                
   
                
                   [
                        'label' => 'MAKLUMBALAS URUSETIA',
                        'headerOptions' => ['style' => 'width:30%', 'class' => 'text-center'],
                        'format' => 'raw',
                                     'hAlign' => 'left',
                         'value' => function ($data) {
                if($data->tblRekod->tblMaklumbalas != null){
                         return Html::a($data->tblRekod->tblMaklumbalas->TugasUtama($data->tblRekod->tblMaklumbalas->id) ).'<br>'.
                              Html::a(''  . $data->tblRekod->tblMaklumbalas->doc_name, Url::to('https://mediahost.ums.edu.my/api/v1/viewFile/' . $data->tblRekod->tblMaklumbalas->hashcode, $schema = true), ['target' => '_blank', 'style' =>  'text-decoration: underline; color:green' ]).
                     '<br>'.'<br>'.
                              '<strong>'.'Urus Setia JPU :'. '<br>'.$data->tblRekod->tblMaklumbalas->kakitangan->CONm.
                                 '<br>'.$data->tblRekod->tblMaklumbalas->department->shortname. '<br>'.$data->tblRekod->tblMaklumbalas->tarikhMaklumbalas. '</strong>'.
                                 '<br>'.'</strong>'.'<br>';
                }else{
                    return 'TIADA MAKLUMBALAS';
                }
                    }
         
        ],
              
                
//                         [
//                        'label' => 'MAKLUMBALAS URUSETIA',
//                     'format' => 'raw',
//                        'headerOptions' => ['style' => 'width:30%'],
//                        
//                                     'hAlign' => 'left',
//                       'value' => function ($data) {
//                if($data->urussetiaJpu->maklumbalas != null){
//                  return   $data->urussetiaJpu->MaklumbalasJpu($data->id);
//                }else{
//                    return 'TIADA MAKLUMBALAS';
//                }
//                    }
//         
//        ],
       
 
                              
                              
                   [
                        'label' => 'STATUS INDEX',
                        'headerOptions' => ['style' => 'width:30%', 'class' => 'text-center'],
                        'format' => 'raw',
                         'value' => function ($data) {
             $list = [1 => '<span class="label label-success">SELESAI</span>', 0 => '<span class="label label-danger">BELUM SELESAI</span>',];                 
             if($data->tblRekod->status == 1){
                   return $list[$data->tblRekod->status] ; 
             }else{
                    return $list[$data->tblRekod->status] ; 
             }
                      
                    },
                         'hAlign' => 'left',
         
        ],
                            
                            
          [
                        'label' => 'PERAKUAN KJ',
                        'headerOptions' => ['style' => 'width:30%', 'class' => 'text-center'],
                        'format' => 'raw',
                         'value' => function ($data) {
                      $list = [1 => '<span class="label label-success">DIPERAKUKAN</span>', 0 => '<span class="label label-danger">BELUM DIPERAKUKAN</span>',  2 => '<span class="label label-danger">DITOLAK</span>'];                 
       
                       return $list[$data->status_kj] ; 
            
                      
                    },
                         'hAlign' => 'left',
         
        ],  
                              
               
   
                [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'TINDAKAN KETUA',
                        'headerOptions' => ['style' => 'width:15%', 'class' => 'text-center'],
                   
                                'value' => function ($data) {
                                $statuspelulus= $data->tblRekod->status;
                                if($statuspelulus == 0){
                                return   Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['perakuan-kj', 'id' => $data->id], ['class' => 'btn btn-default']);
                              
                              }else{
                               return 'SELESAI';
                             }
                     
                        },      
                                
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center','width' => '130px'],
                            ],
                                
                                
                     
      
        ],
                                
                           'pager' => [
                           'firstPageLabel' => 'Halaman Pertama',
                           'lastPageLabel'  => 'Halaman Terakhir'
    ],
                    ]);
         
                    ?> 
            



        </div>
            </div>
  
    </div>
</div>
</div>
