<?php

use yii\helpers\Html;
use app\widgets\EPerkhidmatanWidget;

//echo $this->render('/aduan/_topmenu');
echo $this->render('/e-perkhidmatan/contact');
?>
<div class="aduan-menu">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="col-xs-12 col-md-6">
                <div class="row top_tiles">
                    <div class="animated flipInY">
                        <?php
                        $testingPage1 =  EPerkhidmatanWidget::widget(
                            [
                                'icon' => 'folder-open',
                                'header' => 'Permohonan Baru',
                                'text' => 'Klik di sini untuk membuat permohonan baru <i class="fa fa-hand-pointer-o" aria-hidden="true"></i> ',
                                'number' => ' '
                            ]
                        );
                        echo Html::a($testingPage1, ['e-perkhidmatan/create'], ['title' => 'Sila klik di sini untuk membuat permohonan baru.']);
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <div class="row top_tiles">
                    <div class="animated flipInY">
                        <?php
                        $testingPage2 = EPerkhidmatanWidget::widget(
                            [
                                'icon' => 'folder',
                                'header' => 'Senarai Permohonan',
                                'text' => 'Klik di sini untuk melihat senarai permohonan anda <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>',
                                'number' => ' '
                            ]
                        );
                        echo Html::a($testingPage2, ['e-perkhidmatan/view-list'], ['title' => 'Sila klik di sini untuk melihat senarai permohonan anda.']);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </br>
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <!-- <div class="x_panel"> -->
            <?php echo $this->render('/e-perkhidmatan/info'); ?>
            <!-- </div> -->
        </div>
    </div>


</div>