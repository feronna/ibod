<?php

use kartik\tabs\TabsX;
error_reporting(0);
?>

<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86,1295,1297,1299], 'vars' => []]); ?>

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
                    'label' => '<i class="fa fa-list"></i>&nbsp;Kasut & Pakaian Seragam' , 
                    'content' => $this->render('_senarai_menunggu', ['bil' => 1,  'icno' => $icno, 'senarai' => $senarai, 'title' => $title,]),
                    'url' =>  ['boranguniform/senaraitindakan'],
                    'active' => true
                     
                ], 
                
            ];
            echo TabsX::widget(['items' => $items, 'position' => TabsX::POS_ABOVE, 'bordered' => true, 'encodeLabels' => false, 'align' => TabsX::ALIGN_LEFT]);
            ?>

         <br>
            <ul>
           <li><span class="label label-info">DALAM TINDAKAN KJ</span> : Menunggu perakuan dari Ketua Jabatan</li>
           <li><span class="label label-primary">DALAM TINDAKAN PEGAWAI</span> : Menunggu tindakan dari BPG</li> 
           <!--<li><span class="label label-default">PEMBELIAN TIKET DALAM PROSES</span> : Proses Pembelian tiket</li>-->
           <li><span class="label label-success">BERJAYA</span> : Diluluskan</li> 
           <li><span class="label label-danger">DITOLAK</span> : Tidak Diluluskan</li>
        </ul>
        
    </div> 
<!--            end of dropdownl link-->
  
    </div>
</div>
</div>
