<?php
use yii\helpers\Html;

//use kartik\tabs\TabsX;
error_reporting(0);
?>
 <div class="col-md-12 col-xs-12"> 

<?php echo $this->render('/cutibelajar/_topmenu');?>


    
<div class="col-md-12 col-xs-12"> 
    <div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel" id="rcorners2">
<!--         <div class="x_title">
          <h4><strong><i class="fa fa-home"></i> Halaman Utama</strong></h4> 
         </div>-->
    <div class="x_title">
            <h2><strong>SENARAI PERMOHONAN PENGAJIAN PELANJUTAN</strong></h2>
            
            <div class="clearfix"></div>
        </div>
         
    </div>
</div>
</div>
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>PERMOHONAN BAHARU</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
     
       
        <?= $this->render('_senarai_menunggu_pa', ['bil' => 1,  'icno' => $icno, 'senarai' => $senarai, 'title' => $title])?>
      
<!--     <div class="col-xs-12 col-md-12 col-lg-12"> 
        
            <?//php

//            $items = [
//                [
//                    'label' => '<i class="fa fa-server"></i>&nbsp;Cuti Belajar/Cuti Sabatikal/Latihan Industri',
//                    'content' =>  $this->render('_senarai_menunggu', ['bil' => 1,  'icno' => $icno, 'senarai' => $senarai, 'title' => $title,]), 
//                    'active' => true
//
//                      
//                ], 
//                 [
//                    'label' => '<i class="fa fa-server"></i>&nbsp;Pelanjutan Tempoh Cuti Belajar' , 
//                    'content' => '<p style="color: red"> </p>',
//                    'url' =>  ['lanjutancb/senaraitindakan'], 
//                ], 
                [
                    'label' => '<i class="fa fa-server"></i>&nbsp;Lain-Lain Permohonan' , 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['cblainlain/senaraitindakan'], 
                ], 
                [
                    'label' => '<i class="fa fa-server"></i>&nbsp;LKK' , 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['lkk/senaraitindakan'], 
                ], 
                 [
                    'label' => '<i class="fa fa-server"></i>&nbsp;Lapor Diri', 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['lapordiri/senaraitindakan'], 
                ], 
//                [
//                    'label' => '<i class="fa fa-list"></i>&nbsp;Perpindahan Rumah', 
//                    'content' => '<p style="color: red"> </p>',
//                    'url' =>  ['borangperpindahan/senaraitindakan'], 
//                    
//                ], 
                
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
           
     </div>-->
    </div> 
<!--            end of dropdownl link-->
  
    </div>
</div>

 

