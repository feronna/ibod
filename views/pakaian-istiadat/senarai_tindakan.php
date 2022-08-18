<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Dropdown;
use kartik\tabs\TabsX;
error_reporting(0);
?>

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
                    'label' => '<i class="fa fa-list"></i>&nbsp;Elaun Pakaian Panas',
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['borang/senaraitindakan'], 
                ], 
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Tambang Belas Ihsan', 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['borangehsan/senaraitindakan'], 
                ], 
                 [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Lesen Memandu', 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['boranglesen/senaraitindakan'], 
                ], 
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Pasport', 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['borangpasport/senaraitindakan'], 
                ], 
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Pakaian Istiadat', 
                    'content' => $this->render('_senarai_menunggu', ['bil' => 1,  'icno' => $icno, 'senarai' => $senarai, 'title' => $title,]),
                    'url' =>  ['pakaian-istiadat/senaraitindakan'],
                    'active' => true 
                ], 
                 [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Perpindahan Rumah', 
                    'content' => '<p style="color: red"> </p>',
                     'url' =>  ['borangperpindahan/senaraitindakan'], 
                ], 
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Yuran Keahlian/ Ikhtisas', 
                    'content' => '<p style="color: red"> </p>',
                   'url' =>  ['borangyuran/senaraitindakan'], 
                    
                ],
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Pembelian Alat Komunikasi', 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['borang-alat/senaraitindakan'], 
                    
                ], 
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Pengangkutan Barang', 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['borangpengangkutan/senaraitindakan'], 
                    
                ], 
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Wilayah Asal', 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['borangwilayah/senaraitindakan'], 
                    
                ], 
//                [
//                    'label' => '<i class="fa fa-list"></i>&nbsp;Pakaian Seragam', 
//                    'content' => '<p style="color: red"> </p>',
//                    'url' =>  ['boranguniform/senaraitindakan'],  
//                ],
                
            ];
            echo TabsX::widget(['items' => $items, 'position' => TabsX::POS_ABOVE, 'bordered' => true, 'encodeLabels' => false, 'align' => TabsX::ALIGN_LEFT]);
            ?>

         <br>
            <ul>
            <li><span class="label label-warning">Baru</span> : Permohonan Baru</li>
            <li><span class="label label-primary">Dalam Tindakan Pegawai BSM</span> : Menunggu perakuan dari BSM</li>
            <li><span class="label label-info">Dalam Tindakan KJ BSM</span> : Menunggu kelulusan dari Ketua Jabatan</li>
            <li><span class="label label-default">Arahan Bayaran Kepada Bendahari</span> : Menunggu tindakan dari Bendahari</li>
<!--            <li><span class="label label-success">BERJAYA / EFT</span> : Telah di EFT</li> -->
            <li><span class="label label-danger">Ditolak</span> : Tidak Diluluskan</li>
        </ul>
        
    </div> 
<!--            end of dropdownl link-->
  
    </div>
</div>
</div>
