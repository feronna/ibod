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
                <h2><strong><i class="fa fa-list"></i> Rekod Laporan  </strong></h2>

                <div class="clearfix"></div>
            </div>
                   <div class="x_content">
                <?php
                $items = [
                    [
                        'label' => '<i class="fa fa-list"></i>&nbsp;Senarai Laporan Perlu Pengesahan',
                        'content' => $this->render('_unverified', ['bil'=>$bil,'report'=> $report,]),
                        'active' => true
                    ],
                    [
                        'label' => '<i class="fa fa-list"></i>&nbsp;Rekod Pengesahan',
                        'content' => $this->render('_verified', ['bil'=>$bil,'verified'=> $verified,]),
                        // 'active' => false
                    ],
               
                   
                ];
                echo TabsX::widget(['items' => $items, 'position' => TabsX::POS_ABOVE, 'bordered' => true, 'encodeLabels' => false, 'align' => TabsX::ALIGN_LEFT]);
                ?>

            </div>
        </div>
    </div>
</div>
