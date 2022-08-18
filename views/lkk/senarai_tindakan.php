<?php
use yii\helpers\Html;
use kartik\tabs\TabsX;
error_reporting(0);
?>

<?php echo $this->render('/cutibelajar/_topmenu');?>
 <div class="col-md-12 col-xs-12"> 

<div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel" id="rcorners2">
<!--         <div class="x_title">
          <h4><strong><i class="fa fa-home"></i> Halaman Utama</strong></h4> 
         </div>-->
    <div class="x_title">
            <h2><strong>SENARAI MENUNGGU PERAKUAN</strong></h2>
            
            <div class="clearfix"></div>
        </div>
         <div class="x_content">
             
<?php
  echo Html::a(Yii::t('app','<i class="fa fa-address-card"></i> <span class="label label-info">PERMOHONAN BAHARU</span>'), ['cutisabatikal/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);
//    echo Html::a(Yii::t('app','<i class="fa fa-bar-chart"></i> <span class="label label-info">LAPORAN KEMAJUAN KURSUS</span>'), ['lkk/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);
    echo Html::a(Yii::t('app','<i class="fa fa-bar-chart"></i> <span class="label label-info">LKP</span>'), ['lkk/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);

  echo Html::a(Yii::t('app','<i class="fa fa-list"></i> <span class="label label-info">LAIN - LAIN PERMOHONAN</span>'), ['cblainlain/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);
   echo Html::a(Yii::t('app','<i class="glyphicon glyphicon-align-right"></i> <span class="label label-info">PELANJUTAN TEMPOH</span>'), ['lanjutancb/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-suitcase"></i> <span class="label label-info">LAPOR DIRI</span>'), ['lapordiri/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);

?>
         </div>
    </div>
      </div>
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h5><strong><i class="fa fa-bar-chart"></i> LAPORAN KEMAJUAN PENGAJIAN (LKP) YANG PERLU DISEMAK</strong></h5>
<!--            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                </li>
            </ul>-->
            <div class="clearfix"></div>
        </div>
     
          
              <?= $this->render('_senarai_menunggu', ['bil' => 1,  'icno' => $icno, 'senarai' => $senarai, 'title' => $title])?>
<!--     <div class="col-xs-12 col-md-12 col-lg-12"> 
        
            <?//php

            $items = [
                [
                    'label' => '<i class="fa fa-server"></i>&nbsp;Cuti Belajar/Cuti Sabatikal/Latihan Industri',
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['cutisabatikal/senaraitindakan'],
                      
                ], [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Pelanjutan Tempoh Cuti Belajar', 
                    'content' =>  $this->render('_senarai_menunggu', ['bil' => 1,  'icno' => $icno, 'senarai' => $senarai, 'title' => $title,]), 
                    'active' => true
                    
                ], 
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
 </div>


