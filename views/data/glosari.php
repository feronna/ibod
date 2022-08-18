<?php
use yii\helpers\Html;
use kartik\tabs\TabsX;
?>
<div>
    <?php echo $this->render('_topmenu'); ?>
</div>
<div class="col-md-12 col-xs-12"> 
  <div class="x_panel">
 

        <div class="x_title">
            <h2><strong>Glosari</strong></h2> 
            <div class="clearfix"></div>
        </div>
      
        <div class="col-md-9 col-xs-12">
        <div class="x_panel">
            <?php

           $items = [
               
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;QS Ranking',
                    'content' => $this->render('_list_qsranking'),
                    'active' => true
                    
                ],
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;MyRA',
                    'content' => $this->render('_list_myra'),
                    'active' => false
                    
                ],
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;MyMohes',
                    'content' => $this->render('_list_mymohes'),
                    'active' => false
                    
                ],  
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;SETARA',
                    'content' => $this->render('_list_setara'),
                    'active' => false
                    
                ],  
                 
            ];
            echo TabsX::widget(['items' => $items, 'position' => TabsX::POS_ABOVE, 'bordered' => true, 'encodeLabels' => false, 'align' => TabsX::ALIGN_LEFT]);
            ?>

        </div>
    </div>
        
      
         
 </div>
</div>


