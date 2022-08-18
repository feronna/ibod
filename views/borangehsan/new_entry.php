<?php
 
use kartik\tabs\TabsX;
error_reporting(0);
?>

<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86], 'vars' => []]); ?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
               <h2><strong>PENGISIAN PERMOHONAN KEMUDAHAN STAFF SECARA(OFF-LINE)</strong></h2>
                 
                <div class="clearfix"></div>
            </div>
              
            <?php

            $items = [
                 [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Elaun Pakaian Panas', 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['borang/new-entry'], 
                    
                ],
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Tambang Belas Ihsan', 
                    'content' => $this->render('new_form',['model' => $model, 'model' => $model,
                    'family' => $family,
                    'queryKeluarga' => $queryKeluarga,
                    'kakitangan' => $kakitangan,
                    'searchModel' => $searchModel, 
                    'modelCustomer' => $modelCustomer,
                    'modelFamily' => $modelsFamily,
                    'modelsAddress' => (empty($modelsAddress)) ? [new Reffamily] : $modelsAddress]),
                    'active' => true, 
                ],
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Lesen Memandu',
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['boranglesen/new-entry'], 
           
                ], 
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Pasport', 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['borangpasport/new-entry'], 
                    
                ],
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Pakaian Istiadat', 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['pakaian-istiadat/new-entry'], 
                    
                ],
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Perpindahan Rumah', 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['borangperpindahan/new-entry'], 
                    
                ],
                 [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Yuran Keahlian/ Ikhtisas', 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['borangyuran/new-entry'], 
                    
                ],
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Pembelian Alat Komunikasi', 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['borang-alat/new-entry'], 
                    
                ],
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Pengangkutan Barang', 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['borangpengangkutan/new-entry'], 
                    
                ],
                 [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Wilayah Asal', 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['borangwilayah/new-entry'], 
                    
                ],
                
            ];
            echo TabsX::widget(['items' => $items, 'position' => TabsX::POS_ABOVE, 'bordered' => true, 'encodeLabels' => false, 'align' => TabsX::ALIGN_LEFT]);
            ?>
 
 
</div>
</div>
</div>
 
