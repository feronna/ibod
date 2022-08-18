<?php
 
use kartik\tabs\TabsX;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use kartik\date\DatePicker;
error_reporting(0);

?>
 
    <div class="col-md-12 col-sm-12 col-xs-12"> 


<div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        
          
      
     <div class="col-xs-12 col-md-12 col-lg-12"> 
        
            <?php

            $items = [
               
                [
                    'label' => '<i class="fa fa-money"></i>&nbsp;ESH', 
                    'content' =>  $this->render('_esh'), 
                    'active' => true
                    
                ],
                
                 [
                    'label' => '<i class="fa fa-home"></i>&nbsp;EP', 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['cbadmin/senaraitindakansabatikal'], 
                    
                ],
                [
                    'label' => '<i class="fa fa-car"></i>&nbsp;EAPS', 
                     'content' => '<p style="color: red"> </p>',
                    'url' =>  ['cbadmin/senaraitindakan'], 
                   
                    
                ], 
                [
                    'label' => '<i class="fa fa-th-list"></i>&nbsp;EAP' , 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['cbadmin/senaraitindakanlain'], 
                ], 
                [
                    'label' => '<i class="fa fa-book"></i>&nbsp;EB' , 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['cbadmin/senaraitindakanlain'], 
                ], 
                 [
                    'label' => '<i class="fa fa-users"></i>&nbsp;EBK' , 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['cbadmin/senaraitindakanlain'], 
                ], 
                 [
                    'label' => '<i class="fa fa-home"></i>&nbsp;EBSR' , 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['cbadmin/senaraitindakanlain'], 
                ],
                 [
                    'label' => '<i class="fa fa-university"></i>&nbsp;YURAN PENGAJIAN' , 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['cbadmin/senaraitindakanlain'], 
                ],
                 [
                    'label' => '<i class="fa fa-plane"></i>&nbsp;TIKET PENERBANGAN' , 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['cbadmin/senaraitindakanlain'], 
                ], 
//                
                
            ];
            echo TabsX::widget(['items' => $items, 'position' => TabsX::POS_ABOVE, 'bordered' => true, 'encodeLabels' => false, 'align' => TabsX::ALIGN_LEFT]);
            ?>

         <br>
           
     </div>
    </div> 
<!--            end of dropdownl link-->
  
    </div>
</div>


</div>
 

