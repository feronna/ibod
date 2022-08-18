<?php
 
use kartik\tabs\TabsX;
error_reporting(0);
?>
<?= $this->render('menu') ?> 
 
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86], 'vars' => []]); ?>
<div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><?php echo $title;?></strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
          
      
     <div class="col-xs-12 col-md-12 col-lg-12"> 
        
            <?php

            $items = [
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Audit Plan',
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['msiso/index'],
                      
                ], 
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Notification Letter',  
                    'content' =>  $this->render('senarai_notification_letter', [ 'dataProvider' => $dataProvider, 'bil' => 1,]),  
                    'active' => true                   
                     
                ], 
                
 
                
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
 

