<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use kartik\grid\GridView;

error_reporting(0);
?>


<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Kakitangan untuk Tindakan Tatatertib</strong></h2>
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
            
                ['label' => 'Nama Kakitangan',
                            'value' => 'kakitangan.CONm'
                ],
                  ['label' => 'No Kad Pengenalan',
                            'value' => 'icno'
                ],
                 ['label' => 'Jawatan',
                            'value' => 'kakitangan.jawatan.nama'],
                
                 ['label' => 'Gred',
                 'value' => 'kakitangan.jawatan.gred'],
                            
                 ['label' => 'JFPIU',
                            'value' => 'dept.fullname'
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

