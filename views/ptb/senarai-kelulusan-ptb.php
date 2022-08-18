<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use kartik\grid\GridView;

error_reporting(0);
?>


<div class="col-md-12">
    <?php echo $this->render('/ptb/_menu'); ?>
</div>

<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Kelulusan PTB</strong></h2>
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
            
                ['label' => 'Nama Pemohon',
                            'value' => 'kakitangan.CONm'
                ],
                  ['label' => 'No Kad Pengenalan',
                            'value' => 'icno'
                ],
                 ['label' => 'Jawatan',
                            'value' => 'kakitangan.jawatan.nama'],
                
                 ['label' => 'Gred',
                 'value' => 'kakitangan.jawatan.gred'],
                            
                 ['label' => 'JFPIU Semasa',
                            'value' => 'oldDepartment.fullname'
                ],
                ['label' => 'JFPIU Baharu',
                            'value' => 'approvedDepartment.fullname'
                ],
                ['label' => 'Tarikh Kuatkuasa',
                            'value' => 'effectives'
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

