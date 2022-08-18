<?php
 
use kartik\tabs\TabsX;
error_reporting(0);
?>

<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86], 'vars' => []]); ?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
               <h2><strong>Senarai Permohonan Kemudahan</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
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
                    'url' =>  ['borang/senaraibendahari'], 
                ], [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Tambang Belas Ihsan', 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['borangehsan/senaraibendahari'], 
                ], 
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Lesen Memandu', 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['boranglesen/senaraibendahari'],
                ], 
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Pasport', 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['borangpasport/senaraibendahari'], 
                ], 
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Pakaian Istiadat', 
                    'content' => '<p style="color: red"> </p>', 
                    'url' =>  ['pakaian-istiadat/senaraibendahari'], 
                ], 
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Perpindahan Rumah', 
                    'content' => '<p style="color: red"> </p>', 
                    'url' =>  ['borangperpindahan/senaraibendahari'], 
                ],
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Yuran Keahlian/ Ikhtisas', 
                    'content' => '<p style="color: red"> </p>',  
                    'url' =>  ['borangyuran/senaraibendahari'], 
                ],
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Pembelian Alat Komunikasi', 
                    'content' => '<p style="color: red"> </p>', 
                    'url' =>  ['borang-alat/senaraibendahari'],  
                ], 
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Pengangkutan Barang', 
                    'content' => '<p style="color: red"> </p>', 
                    'url' =>  ['borangpengangkutan/senaraibendahari'],  
                ],
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Wilayah Asal', 
                    'content' =>  $this->render('_list', ['bil' => 1,   'model' => $model]),  
                    'active' => true 
                ],
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Pakaian Seragam', 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['boranguniform/senaraibendahari'],  
                ],
                
            ];
            echo TabsX::widget(['items' => $items, 'position' => TabsX::POS_ABOVE, 'bordered' => true, 'encodeLabels' => false, 'align' => TabsX::ALIGN_LEFT]);
            ?>

         <br>
            <ul>
                <li><span class="label label-warning">BARU</span> : Permohonan Baru</li>
                <li><span class="label label-primary">DALAM TINDAKAN PEGAWAI</span> : Menunggu perakuan dari BSM</li>
                <li><span class="label label-info">DALAM TINDAKAN KJ</span> : Menunggu kelulusan dari BSM</li>
                <li><span class="label label-default">PEMBELIAN TIKET DALAM PROSES</span> : Proses Pembelian tiket</li>
                <!--<li><span class="label label-success">TELAH DITEMPAH</span> : Tempahan tiket selesai</li>--> 
                <li><span class="label label-danger">DITOLAK</span> : Tidak Diluluskan</li>
            </ul>
        
    </div> 
<!--            end of dropdownl link-->
  
 
</div>
</div>
</div>
