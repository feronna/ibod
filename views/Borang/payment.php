<?php
 
use kartik\tabs\TabsX;
error_reporting(0);
?>
 
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
               <h2><strong>Senarai Permohonan Kemudahan </strong></h2>
                 
                <div class="clearfix"></div>
            </div>
              
            <?php

            $items = [
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Arahan Bayaran',
                    'content' =>  $this->render('_elaunTab', [ 'dataProvider' => $dataProvider]), 
                    'active' => true 
                ], 
//                [
//                    'label' => '<i class="fa fa-list"></i>&nbsp;Tambang Belas Ihsan', 
//                    'content' => '<p style="color: red"> </p>',
//                    'url' =>  ['borangehsan/senaraibendahari'], 
//                ], 
                 
                
            ];
            echo TabsX::widget(['items' => $items, 'position' => TabsX::POS_ABOVE, 'bordered' => true, 'encodeLabels' => false, 'align' => TabsX::ALIGN_LEFT]);
            ?>
  
 
</div>
</div>
</div>
 
