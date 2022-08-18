<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */
error_reporting(0);

?>
 <div class="col-md-12 col-sm-12 col-xs-12 "> 
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-search"></i> Carian', ['brp/index']) ?></li>
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['brp/view', 'ICNO' =>   $model2->ICNO ]) ?></li>
        <li>Tambah Rekod LPG</li>
    </ol>
</div>


<?php
$forms = ActiveForm::begin([  //?COOldID  'COOldID' => $model->srb_staff_id]);
    'action' => (['brp/view-rekod-lpg', 'COOldID' => Yii::$app->request->queryParams['COOldID']]),
    'method' => 'post',
]);
?>


 <div class="col-md-12 col-sm-12 col-xs-12 "> 
<ul class="nav nav-tabs">
    <li class="nav-item active">
       <a class="nav-link " href="#bendahari" data-toggle="tab"><?= Yii::t('app','Rekod LPG Bendahari')?></a>
    </li>  
    
     <li class="nav-item active">
         <?php  echo '<li><a data-toggle="tab" href="#brp">Rekod LPG BRP</a></li>'?>
    </li>

</ul>
 </div>


<div class="tab-content">
    <div class="tab-pane fade in active " id="bendahari">
        <br>

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Rekod LPG Bendahari</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                </ul>
                <div class="clearfix"></div>
            </div>
            
            <div class="x_content">
              <?php  
                GridView::widget([
                'dataProvider' => $dataProvider,
       
                'columns' => [
                    [
                        'class' => 'kartik\grid\SerialColumn',
                        'headerOptions' => [
                            'style' => 'display: none;',
                        ]
                    ],
    
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'checkboxOptions' => function ($data) {
                                if($data->srb_batch_code == $data->brpData->t_lpg_id){
                                    return ['disabled' => true];
                                }
                                return [ 'value' => $data->srb_batch_code];
                            },
                        ],
                                    
                                    
                        ['class' => 'kartik\grid\SerialColumn',
                            'header' => 'Bil',
                             'hAlign' => 'center',
                              'vAlign' => 'middle',
                            
                            
                        ],
                        
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'checkboxOptions' => function ($data) {
                                if($data->srb_batch_code == $data->brpData->t_lpg_id){
                                    return ['disabled' => true];
                                }
                                return [ 'value' => $data->srb_batch_code];
                            },
                        ],

                        [
                            'label' => 'Nama Pegawai',
                            'value' => 'srb_staff_id',
                            
                        ],
                                    
                         [
                            'label' => 'LPG',
                            'value' => 'srb_batch_code',
                            
                        ],
                                                 [
                            'label' => 'Status',
                            'value' => 'srb_status',
                            
                        ],
                          [
                            'label' => 'Keterangan',
                            'value' => 'srb_remarks',
                            
                        ],

                     

                      

                    ],
                 'headerRowOptions' => ['class' => 'kartik-sheet-style'],  
                 'resizableColumns' => true,
                 'responsive' => false,
                 'responsiveWrap' => false,
                    'hover' => true,
                    'floatHeader' => true,
                    'floatHeaderOptions' => [
                        'position' => 'absolute',
                    ],
                ]);
                              
                $gridColumns = [
      
                         [
                            'class' => 'yii\grid\CheckboxColumn',
                            'checkboxOptions' => function ($data) {
                                if($data->srb_batch_code == $data->brpData->t_lpg_id){
                                    return ['disabled' => true];
                                }
                                return [ 'value' => $data->srb_batch_code];
                            },
                        ],
                                    
                    ['class' => 'kartik\grid\SerialColumn',
                            'header' => 'Bil',
                             'hAlign' => 'center',
                              'vAlign' => 'middle',
                            
                            
                            ],
                        
                        

                        [
                            'label' => 'Nama Pegawai',
                            'value' => 'biodataSendiri.CONm',
                            
                        ],
                                    
                         [
                            'label' => 'LPG',
                            'value' => 'srb_batch_code',
                            
                        ],
                             [
                            'label' => 'Status',
                            'value' => 'srb_status',
                            
                        ],
                          [
                            'label' => 'Keterangan',
                            'value' => 'srb_remarks',
                            
                        ],

                    ];
                    
                              echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumns,
                            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                         
                            'toolbar' => [
                                [
                                 
                                ],
                            ],
                                  
                            'bordered' => true,
                            'striped' => false,
                            'condensed' => false,
                            'responsive' => true,
                            'hover' => true,
                                   'panel' => [
                                'type' => GridView::TYPE_DEFAULT,
                                'heading' => Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-primary', 'name' => 'simpan', 'value' => 'submit_1']).Html::submitButton(Yii::t('app', '<i class="fa fa-cancel-o"></i>&nbsp;Reset'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1'])
                         ],
                         
                        ]);
                ?>
            
            </div>
                <?php ActiveForm::end(); ?>
        </div>
    </div>
        
    </div>
        
        <div class="tab-pane fade " id="brp">
        <br>

          <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Rekod LPG BRP</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                </ul>
                <div class="clearfix"></div>
            </div>
            
            <div class="x_content">
              <?php  
                GridView::widget([
                'dataProvider' => $dataProvider2,
                'headerRowOptions' => ['class' => 'kartik-sheet-style'],  
                'resizableColumns' => true,
                'responsive' => false,
                'responsiveWrap' => false,
                    'hover' => true,
                    'floatHeader' => true,
                    'floatHeaderOptions' => [
                        'position' => 'absolute',
                    ],
                ]);
                              
                $gridColumns = [
      
                   
                                    
                    ['class' => 'kartik\grid\SerialColumn',
                            'header' => 'Bil',
                             'hAlign' => 'center',
                              'vAlign' => 'middle',
                            
                            
                            ],
                        
                        

                        [
                            'label' => 'Nama Pegawai',
                            'value' => 'kakitangan.CONm',
                   
                            
                        ],
                                    
                         [
                            'label' => 'LPG',
                             'value' => 't_lpg_id',
                      
                            
                        ],
                          [
                            'label' => 'Keterangan',
                            'value' => 'remark',
                            
                        ],

                    ];
                    
                              echo GridView::widget([
                            'dataProvider' => $dataProvider2,
                            'columns' => $gridColumns,
                            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                         
                            'toolbar' => [
                                [
                                 
                                ],
                            ],
                                  
                            'bordered' => true,
                            'striped' => false,
                            'condensed' => false,
                            'responsive' => true,
                            'hover' => true,
                                   'panel' => [
                                'type' => GridView::TYPE_DEFAULT,
                               // 'heading' => Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-primary', 'name' => 'simpan', 'value' => 'submit_1']).Html::submitButton(Yii::t('app', '<i class="fa fa-cancel-o"></i>&nbsp;Reset'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1'])
                         ],
                         
                        ]);
                ?>
            
            </div>

        </div>
    </div>
        
</div>
</div>
 


