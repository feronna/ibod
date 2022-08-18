<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use kartik\grid\GridView;
error_reporting(0);
?>

<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/harta/_menu');?>
</div>
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Permohonan Isytihar Harta</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        
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
                       
                    ],
                
                [
                    'label' => 'Nama Pemohon',
                    'value' => 'AssetOwnerNm',
                     'format' => 'raw',
                ], 
                          
                [
                    'label' => 'Jenis Permohonan',
                    'value' => 'jenisPermohonan',
                     'format' => 'raw',
                    ], 
                
                [
                    'label' => 'Tarikh Isytihar',
                    'value' => 'tarikhDihantar',
                     'format' => 'raw',
                ], 
                
                      [
                            'label' => 'Tarikh Kelulusan JTKK',
                            'attribute' =>function($data){
                              if($data->ADEdrsdDt == null){
                                return 'Belum Disahkan';
                              }else{
                                  return $data->tarikhDisahkan;
                              }
                             
                           
                            },
                            'format' => 'raw',
                       
                            'hAlign' => 'center',
                       

                        ],
                
                 [
                    'label' => 'Status Borang',
                    'value' => 'statusLabel',
                     'format' => 'raw',
                ],
                            
                   [
                    'label' => 'Lihat',
         
                    'value' => function($model){
                    
                    return  Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['borang', 'id' => $model->id]);
             
                    },
                     'format' => 'raw',
                     'hAlign' => 'center',
                 
                ], 
                   
            ],
       
            
                'resizableColumns' => true,
                'responsive' => false,
                'responsiveWrap' => false,
              
                
                    'floatHeaderOptions' => [
                        'position' => 'absolute',
                    ],
                ]);
                ?>
    </div>
</div>
</div>

