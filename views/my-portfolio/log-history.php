<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use kartik\grid\GridView;

error_reporting(0);
?>

<div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>JADUAL PENGEMASKINIAN</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
                <div class="table-responsive">
          <table class="table table-sm table-bordered">
                      <?=
             GridView::widget([
                 
            'dataProvider' => $provider,
                'options' => [
                'class' => 'table-responsive',
                    ],
                  'emptyText'=> 'Tiada Rekod',
                'summary' => '',
                 'columns' => [
                   ['header' =>'Bil.',
                 'class' => 'kartik\grid\SerialColumn',
          
                    'format' => 'raw',
                    ],
                       
                    [
                            'label' => 'Tajuk',
                            'attribute' =>function($data){
                              if($data->activity == '3'){
                                return 'Pengkemaskinian Deskripsi Tugas';
                              }
                              if ($data->activity == '2'){
                                  return 'Data Baharu';
                              }
                           
                            },
                            'format' => 'raw',
                       
                            'hAlign' => 'center',
                       

                        ],
                                    
                  ['label' => 'Tarikh Kemaskini',
                            'value' => 'tarikhKemaskini'
                ],
                 ['label' => 'Bahagian',
                            'value' => 'table_name'],
                
                            
                 [
                            'label'=>'Tindakan',
                            'format' => 'raw',
                            'value'=>function ($data){
                             
                             if($data->activity == 2){
                                 return  Html::button('<i aria-hidden="true"></i>DATA BAHARU', ['value' => \yii\helpers\Url::to(['keterangan-log', 'id' => $data->id]), 'class' => 'mapBtn btn-sm btn-success btn-block','disabled' => true]);
                                }
                              else{
                              return  Html::button('<i class="fa fa-info" aria-hidden="true"></i> INFO', ['value' => \yii\helpers\Url::to(['keterangan-log', 'id' => $data->id]), 'class' => 'mapBtn btn-sm btn-danger btn-block']);
                                }                        

                            },
                              'hAlign' => 'center',
                              'vAlign' => 'middle',
                        ],
               
                   
            ],
                            
                            
            
                'resizableColumns' => true,
                'responsive' => false,
                'responsiveWrap' => false,
              
                
                    'floatHeaderOptions' => [
                        'position' => 'absolute',
                    ],
        ]);?>
                      </table>
      
        </div>
    </div>
</div>
</div>
</div>
        
   

 