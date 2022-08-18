<?php

use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
//use kartik\date\DatePicker;
use dosamigos\datepicker\DatePicker;
error_reporting(0);
use kartik\export\ExportMenu;
?>

<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/memorandum/_menu');?> 
</div>


<div class="row">
 
 <div class="col-md-12 col-sm-12 col-xs-12">
           <div class="table-responsive">
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
                    'action' => ['senarai-memorandum'],
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
        
  

   <div class="x_panel">

        
        <div class="x_content">

         <?= Html::a('Tambah Rekod Memorandum', ['tambah-rekod'], ['class' => 'btn btn-warning']);?> 
         <?= Html::a('Tambah Tindakan Memorandum', ['tambah-tindakan'], ['class' => 'btn btn-info']);?> 
        </div>
    </div>



<div class="row">
<div class="col-md-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2>Senarai Memorandum</h2>
        
            <div class="clearfix"></div>
        </div>
           
                
                   <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
      
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
                     'headerOptions' => ['style' => 'width:5%', 'class' => 'text-center'],
                        'label' => 'TAHUN',
                        'value' => 'tblRekod.tahun',
                        'hAlign' => 'left',
                      
                    ],
                    
                      [
                     'headerOptions' => ['style' => 'width:5%', 'class' => 'text-center'],
                        'label' => 'TARIKH MESYUARAT',
                        'value' => 'tblRekod.tarikhRekod',
                        'hAlign' => 'left',
                      
                    ],
                    
                        [
                     'headerOptions' => ['style' => 'width:5%', 'class' => 'text-center'],
                        'label' => 'JAFPIB',
                        'value' => 'department.shortname',
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
                     'headerOptions' => ['style' => 'width:100%', 'class' => 'text-center'],
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
                    
                    
//                                         [
//                        'label' => 'PERAKUAN KJ',
//                        'headerOptions' => ['style' => 'width:30%', 'class' => 'text-center'],
//                        'format' => 'raw',
//                         'value' => function ($data) {
//             $list = [1 => '<span class="label label-success">DIPERAKU</span>', 0 => '<span class="label label-danger">BELUM DIPERAKU</span>',];                 
//             if($data->tblMaklumbalasPtj->status_kj != NULL){
//                   return $list[$data->tblMaklumbalasPtj->status_kj] ; 
//             }else{
//                    return 'DALAM PROSES' ; 
//             }
//                      
//                    },
//                         'hAlign' => 'left',
//         
//        ], 
              
                              [
                        'label' => 'MAKLUMBALAS JAFPIB',
                        'headerOptions' => ['style' => 'width:30%', 'class' => 'text-center'],
                       'format' => 'raw',
                            
                       'value' => function ($data) {
                         if($data->tblMaklumbalasPtj2->maklumbalas_ptj != null){
                         return $data->tblMaklumbalasPtj2->MaklumbalasJafpib($data->id);
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
//                    ExportMenu::FORMAT_CSV => true,
//                    ExportMenu::FORMAT_TEXT => true,
//                    ExportMenu::FORMAT_HTML => true,
//                    ExportMenu::FORMAT_PDF => true,
//                    ExportMenu::FORMAT_EXCEL => true,
//                    ExportMenu::FORMAT_EXCEL_X => true,
//                        [
//                            'options' => ['style' => 'float: right; font-size:18px;'],
//                        //    'label' => 'Muat turun',
//                            'fontAwesome' => true,
//                            'icon' => ['class'=>'fa fa-download'],
//                            'config' => [
//                                'methods' => [
//                                    'SetHeader' => ['E-memorandum'],
//                                ]
//                            ],
//                        ],
//                   // 'clearBuffers' => true,
//
//                ],
//                'showConfirmAlert' => true,
//                'filename' => 'E-memorandum',
//                'asDropdown' => true,
                            
               'filename' => 'Senarai Memorandum',
//                'clearBuffers' => true,
//                'stream' => false,
//             //   'folder' => '@app/web/files/myidp/.',
//            //    'linkPath' => '/files/myidp/',
//                'batchSize' => 10,
            ]);
                        
            ?>
           <div class="x_content">
   
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                            'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                  [
                     'headerOptions' => ['style' => 'width:5%', 'class' => 'text-center'],
                        'label' => 'TAHUN',
                        'value' => 'tblRekod.tahun',
                        'hAlign' => 'left',
                      
                    ],
                    
                      [
                     'headerOptions' => ['style' => 'width:5%', 'class' => 'text-center'],
                        'label' => 'TARIKH MESYUARAT',
                        'value' => 'tblRekod.tarikhRekod',
                        'hAlign' => 'left',
                      
                    ],
                    
               
                    
                     [
                       'headerOptions' => ['style' => 'width:10%', 'class' => 'text-center'],
                        'label' => 'BIL JPU',
                              'format' => 'raw',
                        'value' => 'tblRekod.bil_jpu',
                 //      'value' => function ($model) {
                 //      return  Html::a($model->tblRekod->bil_jpu,["jana-index", 'id' => $model->tblRekod->id], ['target' => '_blank', 'style' => 'text-decoration: underline; text-decoration-color: red; ' ]);
                 //      },
                       'hAlign' => 'left',
                      
                    ],
                    
                        [
                       'headerOptions' => ['style' => 'width:10%', 'class' => 'text-center'],
                        'label' => 'KALI KE-',
                        'value' => 'tblRekod.kali_ke',
                        'hAlign' => 'left',
                      
                    ],
                    
                    
                    
                    [
                     'headerOptions' => ['style' => 'width:100%', 'class' => 'text-center'],
                        'format' => 'raw',
                'label' => 'PERKARA / MINIT',
               'value' => function ($model) {
 
                if ($model->tblRekod->doc_name) {
                    return  Html::a($model->tblRekod->perkara, ["jana-index", 'id' => $model->id], ['style' =>  'text-decoration: underline; ']) .'<br>'.'<br>'. $model->perkara.'<br>'.'<br>'.'<strong>'.
                   //return Html::a($data->kakitangan->CONm, ["list-senarai", 'id' => $data->icno], ['target' => '_blank']);
              //        return $data->CONm."</br>".'<span style="color:#FF0000;text-align:center;">** BELUM ISYTIHAR HARTA</span>';
                            
                     Html::a(''  . $model->tblRekod->doc_name, Url::to('https://mediahost.ums.edu.my/api/v1/viewFile/' . $model->tblRekod->hashcode, $schema = true), ['target' => '_blank', 'style' =>  'text-decoration: underline; color:green' ]);
                } else {
                    
                    return Html::a($model->tblRekod->perkara, ["jana-index", 'id' => $model->id], ['target' => '_blank','style' =>  'text-decoration: underline; ']).'<br>'.'<br>'.$model->perkara.'<br>'.'<br>'.'<strong>'.
                     'Tiada Lampiran';
                }
            }
                      
                    ],
                    
                    
//                                         [
//                        'label' => 'PERAKUAN KJ',
//                        'headerOptions' => ['style' => 'width:30%', 'class' => 'text-center'],
//                        'format' => 'raw',
//                         'value' => function ($data) {
//             $list = [1 => '<span class="label label-success">DIPERAKU</span>', 0 => '<span class="label label-danger">BELUM DIPERAKU</span>',];                 
//             if($data->tblMaklumbalasPtj->status_kj != NULL){
//                   return $list[$data->tblMaklumbalasPtj->status_kj] ; 
//             }else{
//                    return 'DALAM PROSES' ; 
//             }
//                      
//                    },
//                         'hAlign' => 'left',
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
                            'headerOptions' => ['style' => 'width:10%', 'class' => 'text-center'],
                            'format' => 'raw',
                               'hAlign' => 'left',
                            'contentOptions' => ['style' => 'width: 150px;'],
                            'value' => function ($data) {
                              
                                    return Select2::widget([
                                        'name' => 't' . $data->id,
                                        'value' => $data->status,
                                       'data' => [0 => 'BELUM SELESAI', 1 => 'SELESAI'],
                                        'options' => ['placeholder' => ''],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                        ],
                                    ]);
                                
                            },
                        ],
                              
               
   
                [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'TINDAKAN',
                        'headerOptions' => ['style' => 'width:15%', 'class' => 'text-center'],
                        'value' => function ($data) {
                                  $statuspelulus= $data->status;
                                    if($statuspelulus == 0){                 
                                return   Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['detail-memorandum', 'id' => $data->tblRekod->id, 'id_perkara' => $data->id ], ['class' => 'btn btn-default']).
                                Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['kemaskini-memorandum', 'id' => $data->tblRekod->id], ['class' => 'btn btn-default']).
                                Html::a('<i class="fa fa-plus" aria-hidden="true"></i>', ['tambah-maklumbalas-urusetia','id' => $data->tblRekod->id, 'id_perkara' => $data->id], ['class' => 'btn btn-default']);
                                    }else{
                                return   Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['detail-memorandum', 'id' => $data->tblRekod->id,  'id_perkara' => $data->id], ['class' => 'btn btn-default']);
                              
                             }
                     
                        },
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center','width' => '130px'],
                            ],
                                
                                
                         [
                            'class' => 'yii\grid\CheckboxColumn',
                            'checkboxOptions' => function ($data) {
                                if ($data->status == 1) {
                                    return ['disabled' => 'disabled'];
                                }
                                return ['value' => $data->id, 'checked' => true];
                            },
                        ],
      
        ],
                                
                           'pager' => [
                           'firstPageLabel' => 'Halaman Pertama',
                           'lastPageLabel'  => 'Halaman Terakhir'
    ],
                    ]);
         
                    ?> 
            
                 <div class="form-group" align="right">
     
              <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-primary', 'name' => 'simpan', 'value' => 'submit_1']) ?>

                </div>


       
          
         <?php ActiveForm::end(); ?>
    </div>
</div>
</div>
</div></div></div>
</div>