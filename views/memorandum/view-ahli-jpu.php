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
use dosamigos\datepicker\DatePicker;
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
                    'action' => ['view-ahli-jpu'],
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
        
  
           
                      <?=
                            $form->field($searchModel, 'carian_jafpib')->label(false)->widget(Select2::classname(), [
                           'data' => ArrayHelper::map(app\models\hronline\Department::find()->all(), 'id', 'shortname'),
                             'options' => ['placeholder' => 'Carian JAFPIB', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                                ],
                            ]);
                            ?> 
                
         
                
                   <?= $form->field($searchModel, 'carian_tarikh_rekod')->widget(DatePicker::className(),
                                  ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                                  ])->label(false);?>
                
                
                
          
                
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
            <h2>Senarai Memorandum</h2>
        
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
                        'value' => 'tblRekod.bil_jpu',
                              'hAlign' => 'left',
                    ],
                    
                            [
                       'headerOptions' => ['style' => 'width:10%', 'class' => 'text-center'],
                        'label' => 'KALI KE-',
                        'value' => 'tblRekod.kali_ke',
                        'hAlign' => 'left',
                      
                    ],
                                
                          [
                     'headerOptions' => ['style' => 'width:60%', 'class' => 'text-center'],
                        'format' => 'raw',
                'label' => 'PERKARA / MINIT',
               'value' => function ($model) {
 
                if ($model->tblRekod->doc_name) {
                    return $model->tblRekod->perkara.'<br>'.'<br>'.$model->perkara.'<br>'.'<br>'.'<strong>'.
                     Html::a(''  . $model->tblRekod->doc_name, Url::to('https://mediahost.ums.edu.my/api/v1/viewFile/' . $model->tblRekod->hashcode, $schema = true), ['target' => '_blank', 'style' =>  'text-decoration: underline; color:green' ]);
                } else {
                    return $model->tblRekod->perkara.'<br>'.'<br>'.$model->perkara.'<br>'.'<br>'.'<strong>'.
                     'Tiada Lampiran';
                }
            }
                      
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
        
                 if($data->tblMaklumbalasPtj2->maklumbalas_ptj != null){
                         return  $data->tblMaklumbalasPtj2->MaklumbalasJafpib($data->id);
                }else{
                    return 'TIADA MAKLUMBALAS';
                }
                    }
         
        ],
                
                     
                 [
                        'label' => 'MAKLUMBALAS URUSETIA',
                     'format' => 'raw',
                        'headerOptions' => ['style' => 'width:30%'],
                        
                                     'hAlign' => 'left',
                       'value' => function ($data) {
                if($data->tblMaklumbalasUrussetia->maklumbalas != null){
                  return   $data->tblMaklumbalasUrussetia->MaklumbalasJpu($data->id);
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
//                'showConfirmAlert' => FALSE,
                'filename' => 'E-memorandum',
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
                        'value' => 'tblRekod.bil_jpu',
                              'hAlign' => 'left',
                      
                    ],
                    
                            [
                       'headerOptions' => ['style' => 'width:10%', 'class' => 'text-center'],
                        'label' => 'KALI KE-',
                        'value' => 'tblRekod.kali_ke',
                        'hAlign' => 'left',
                      
                    ],
                    
                                
                          [
                     'headerOptions' => ['style' => 'width:60%', 'class' => 'text-center'],
                        'format' => 'raw',
                'label' => 'PERKARA / MINIT',
               'value' => function ($model) {
 
                if ($model->tblRekod->doc_name) {
                    return $model->tblRekod->perkara.'<br>'.'<br>'.$model->perkara.'<br>'.'<br>'.'<strong>'.
                     Html::a(''  . $model->tblRekod->doc_name, Url::to('https://mediahost.ums.edu.my/api/v1/viewFile/' . $model->tblRekod->hashcode, $schema = true), ['target' => '_blank', 'style' =>  'text-decoration: underline; color:green' ]);
                } else {
                    return $model->tblRekod->perkara.'<br>'.'<br>'.$model->perkara.'<br>'.'<br>'.'<strong>'.
                     'Tiada Lampiran';
                }
            }
                      
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
        
                 if($data->tblMaklumbalasPtj2->maklumbalas_ptj != null){
                         return  $data->tblMaklumbalasPtj2->MaklumbalasJafpib($data->id);
                }else{
                    return 'TIADA MAKLUMBALAS';
                }
                    }
         
        ],
                
                     
               [
                        'label' => 'MAKLUMBALAS URUSETIA',
                     'format' => 'raw',
                        'headerOptions' => ['style' => 'width:30%'],
                        
                                     'hAlign' => 'left',
                       'value' => function ($data) {
                if($data->tblMaklumbalasUrussetia->maklumbalas != null){
                  return   $data->tblMaklumbalasUrussetia->MaklumbalasJpu($data->id);
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
                            
//                                 [
//                        'label' => 'PERAKUAN KJ',
//                        'headerOptions' => ['style' => 'width:30%', 'class' => 'text-center'],
//                        'format' => 'raw',
//             'value' => function ($data) {
//             $list = [1 => '<span class="label label-success">DIPERAKU</span>', 0 => '<span class="label label-danger">BELUM DIPERAKU</span>',];                 
//             if($data->tblMaklumbalasPtj->status_kj != NULL){
//                   return $list[$data->tblMaklumbalasPtj->status_kj] ; 
//             }else{
//                    return 'DALAM PROSES' ; 
//             } 
//            
//                      
//                    },
//                         'hAlign' => 'left',
//         
//        ], 
                              
               
   
                [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'LIHAT',
                        'headerOptions' => ['style' => 'width:15%', 'class' => 'text-center'],
                        'value' => function ($data) {
                            return  Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['detail-memorandum', 'id' => $data->tblRekod->id, 'id_perkara' => $data->id], ['class' => 'btn btn-default']);
                         
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
