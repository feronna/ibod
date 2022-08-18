<?php
 
use kartik\tabs\TabsX;
error_reporting(0);
?>
 
<?php echo $this->render('/cutibelajar/_topmenu');?>

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
//                [
//                    'label' => '<i class="fa fa-graduation-cap"></i>&nbsp;Cuti Belajar',
//                    'content' => '<p style="color: red"> </p>',
//                    'url' =>  ['/cbadmin/senaraitindakan1'],
//                      
//                ], [
//                    'label' => '<i class="fa fa-list"></i>&nbsp;Cuti Sabatikal/Latihan Industri', 
//                    'content' => '<p style="color: red"> </p>',
//                    'url' =>  ['cbadmin/senaraitindakansabatikal'], 
//                    
//                ],[
//                    'label' => '<i class="fa fa-clock-o"></i>&nbsp;Pelanjutan Tempoh Cuti Belajar', 
//                     'content' => '<p style="color: red"> </p>',
//                    'url' =>  ['/cbadmin/senaraitindakan'], 
//                    
//                ], 
//                [
//                    'label' => '<i class="fa fa-server"></i>&nbsp;Lain-Lain Permohonan' , 
//                    'content' => '<p style="color: red"> </p>',
//                    'url' =>  ['/cbadmin/senaraitindakanlain'], 
//                ], 
                [
                    'label' => '<i class="fa fa-book"></i>&nbsp;LKK' , 
                     'content' =>  $this->render('/lkk/_senarai_menunggu', ['bil' => 1,  'icno' => $icno, 'senarai' => $senarai, 'title' => $title,]), 
                    'active' => true
                ], 
                 [
                    'label' => '<i class="fa fa-suitcase"></i>&nbsp;Lapor Diri', 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['cbadmin/senaraitindakanlapor'], 
                ], 
                [
                    'label' => '<i class="fa fa-plane"></i>&nbsp;Tiket Penerbangan', 
                     'content' => '<p style="color: red"> </p>',
                    'url' =>  ['cbadmin/senaraitindakantiket'], 
                    
                ], 
                
//                [
//                    'label' => '<i class="fa fa-list"></i>&nbsp;Pembelian Alat Komunikasi', 
//                    'content' => '<p style="color: red"> </p>',
//                    'url' =>  ['borang-alat/senaraitindakan'], 
//                    
//                ], 
 
                
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
 

