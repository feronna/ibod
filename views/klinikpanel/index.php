<?php

use kartik\widgets\DatePicker;
use kartik\tabs\TabsX;
use yii\helpers\Html;
error_reporting(0); 

?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1162], 'vars' => []]); ?>
<?= $this->render('_inquiry') ?>
<div class="row top_tiles">
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-pencil-square-o"></i></div>
            <div class="count">Mohon</div>
            <h3>Tambah Peruntukan</h3>
            <p><?= Html::a('<i class="text-success fa fa-pencil"></i><strong> Klik untuk mohon </strong>', ['klinikpanel/mohon']) ?></p>
            <p><?= Html::a('<i class="text-success fa fa-check-square"></i><strong> Semakan Permohonan </strong>', ['klinikpanel/semak']) ?></p>
            
            <!-- <p style="color: green"><strong>Dalam fasa pengujian</strong></p> -->
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
<!--            <div class="icon"><i class="fa fa-money"></i></div>-->
            <div class="count"> RM <?= $layak->max_tuntutan ?></div>
            <h3>Kelayakan</h3>
            <p><strong>Tahun <?= date('Y') ?></strong></p>
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
<!--            <div class="icon"><i class="fa fa-money"></i></div>-->
            <div class="count"> RM <?= $layak->current_balance ?></div>
            <h3>Baki Peruntukan</h3>
            <p><strong>01/01/<?= date('Y') ?> Hingga 31/12/<?= date('Y') ?></strong></p>
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
<!--            <div class="icon"><i class="fa fa-list"></i></div>-->
            <div class="count"> RM <?php if($tuntutan->jum_tuntutan == NULL){
                echo '0.00';
            }else{
                echo $tuntutan->jum_tuntutan;
            } ?></div>
            <h3>Tuntutan</h3>
            <p><strong>Rawatan Klinik Panel</strong></p>
        </div>
    </div>  
</div>
<div class="row">


    <div class="col-md-9 col-xs-12">
        <div class="x_panel">
            <?php

           $items = [
               
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Senarai Klinik Panel UMS',
                    'content' => $this->render('_list_klinik', ['bil'=> 1, 'klinik'=> $klinik, 'searchModel'=>$searchModel]),
                    'active' => true
                    
                ],
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Senarai Klinik Pusat Kesihatan Universiti HUMS',
                    'content' => $this->render('_list_pku', ['bil'=> 1, 'pku'=> $pku]),
                    'active' => false
                    
                ],
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Rekod Lawatan Klinik Panel',
                    'content' => $this->render('_list_lawatan', ['dataProvider'=>$dataProvider]),
                    'active' => false
                    
                ],  
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Rekod Lawatan Klinik Bukan Panel',
                    'content' => $this->render('_list_bukanpanels', ['bukanpanels'=>$bukanpanels]),
                    'active' => false
                    
                ],  
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Rekod Lawatan PKU HUMS (Sistem MedCare)',
                    'content' => $this->render('_list_medcare', ['medcares'=>$medcares]),
                    'active' => false
                    
                ],  
                  
               [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Rekod Penambahan Peruntukan',
                    'content' => $this->render('_list_topup', ['bil' => 1, 'topup' => $topup, 'user'=>Yii::$app->user->getId()]),
                    'active' => false
                ],
                  [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Rekod Keluarga',
                    'content' => $this->render('_list_keluarga', ['bil' => 1, 'keluarga' => $keluarga,]),
                    'active' => false
                ],
                  [
                    'label' => '<i class="fa fa-download"></i>&nbsp;Muat Turun Borang',
                    'content' => $this->render('_list_borang'),
                    'active' => false
                ],
            ];
            echo TabsX::widget(['items' => $items, 'position' => TabsX::POS_ABOVE, 'bordered' => true, 'encodeLabels' => false, 'align' => TabsX::ALIGN_LEFT]);
            ?>

        </div>
    </div>

    <div class="col-md-3 col-xs-12">
     <div class="animated flipInY ">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-hospital-o"></i></div>
            <div class="count"> RM <?php if($bknpanel->tuntutan == NULL){
                echo '0.00';
            }else{
                echo $bknpanel->tuntutan;
            } ?></div>
            <h3>Tuntutan</h3>
            <p><strong>Rawatan Klinik Bukan Panel</strong></p>
        </div>
    </div>
     <div class="animated flipInY ">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-hospital-o"></i></div>
            <div class="count"> RM <?php if($hums->deduct_amt == NULL){
                echo '0.00';
            }else{
                echo $hums->deduct_amt;
            } ?></div>
            <h3>Tuntutan</h3>
            <p><strong>Rawatan PKU HUMS (Sistem MedCare)</strong></p>
        </div>
    </div>
        <div class="x_panel"> 
            <div class="x_title">
                <h2><i class="fa fa-calendar"></i>&nbsp;Kalender</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php
                echo DatePicker::widget([
                    'name' => 'dp_5',
                    'type' => DatePicker::TYPE_INLINE,
                    'value' => date('d/m/Y'),
                    'type' => DatePicker::TYPE_INLINE,
                    'pluginOptions' => [
                        'format' => 'dd/mm/yyyy',
//                        'multidate' => true
                    ],
                    'options' => [
                        // you can hide the input by setting the following
                        'style' => 'display:none'
                    ]
                ]);
                ?>
            </div>
        </div>
        
    </div>
</div>

