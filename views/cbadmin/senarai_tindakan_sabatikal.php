<?php
 
use kartik\tabs\TabsX;
use yii\helpers\Html;

error_reporting(0);
?>
 
<?php echo $this->render('/cutibelajar/_topmenu');?>

<div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><?php echo $title;?></strong></h2>
            <p align="right"><?= Html::a('Kembali', ['cbadmin/page-semak'], 
         ['class' => 'btn btn-primary btn-sm']) ?></p>
            
            <div class="clearfix"></div>
        </div>
          
      
     <div class="col-xs-12 col-md-12 col-lg-12"> 
        
            <?php

            $items = [
               
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Sarjana/PHD/Post Doktoral/Sub Kepakaran', 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['cbadmin/senaraitindakan1'], 
                    
                ],
                
                 [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Cuti Sabatikal/Latihan Industri', 
                    'content' =>  $this->render('/cutisabatikal/_senarai_menunggu_sabatikal', ['bil' => 1,  'icno' => $icno, 'senarai' => $senarai, 'title' => $title,]), 
                    'active' => true
                   
                    
                ],
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Pelanjutan Tempoh Cuti Belajar', 
                     'content' => '<p style="color: red"> </p>',
                    'url' =>  ['cbadmin/senaraitindakan'], 
                   
                    
                ], 
 [
                    'label' => '<i class="fa fa-server"></i>&nbsp;Lain-Lain Permohonan' , 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['cbadmin/senaraitindakanlain'], 
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
 

