<?php

use kartik\widgets\DatePicker;
use kartik\tabs\TabsX;
use yii\helpers\Html;
use app\widgets\TopMenuWidget;
?>
<?= $this->render('/keselamatan/_topmenu') ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-list"></i> Rekod Tukar Syif & STS  </strong></h2>

                <div class="clearfix"></div>
            </div>
                   <div class="x_content">
                <?php
                $items = [
                    // [
                    //     'label' => '<i class="fa fa-list"></i>&nbsp;Senarai Cuti',
                    //     'content' => $this->render('_list_cuti', ['bil' => 1, 'cuti_rekod' => $cuti_rekod,]),
                    //     'active' => true
                    // ],
               
                    [
                        'label' => '<i class="fa fa-address-book"></i>&nbsp;Senarai Tukar Syif',
                        'content' => $this->render('_list_syif', ['bil' => 1, 'syif' => $syif,]),
                    ],
                    [
                        'label' => '<i class="fa fa-list"></i>&nbsp;Senarai STS',
                        'content' => $this->render('_list_sts_do', ['bil' => 1, 'sts' => $sts,]),
                    ],
                ];
                echo TabsX::widget(['items' => $items, 'position' => TabsX::POS_ABOVE, 'bordered' => true, 'encodeLabels' => false, 'align' => TabsX::ALIGN_LEFT]);
                ?>

            </div>
        </div>
    </div>
</div>
