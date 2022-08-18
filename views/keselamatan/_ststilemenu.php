<?php

use yii\helpers\Html;

?>
<div class="row">
      <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2>Halaman Clock In</h2> 
                <div class="clearfix"></div>
            </div>
            <div class="x_content"> 
                <div class="row">
                    <div class="col-xs-12 col-md-3">
                        <?php
                        $hakiki = \yiister\gentelella\widgets\StatsTile::widget(
                                        [
                                            'icon' => 'clock-o',
                                            'header' => 'Hakiki',
                                            'text' => '',
                                            'number' => 'Hakiki',
                                        ]
                        );
                        echo Html::a($hakiki, ['keselamatan/laporan-kehadiran-individu']);
                        ?>
                    </div>
                    <div class="col-xs-12 col-md-3">
                         <?php
                        $ot = \yiister\gentelella\widgets\StatsTile::widget(
                                        [
                                            'icon' => 'clock-o',
                                            'header' => 'Lebih Masa',
                                            'text' => '',
                                            'number' => 'LMJ',
                                        ]
                        );
                        echo Html::a($ot, ['keselamatan/laporan-kehadiran-ot']);
                        ?>
                    </div>
                    <div class="col-xs-12 col-md-3">
                        <?php
                        $lmt = \yiister\gentelella\widgets\StatsTile::widget(
                                        
                                           [
                                            'icon' => 'clock-o',
                                            'header' => 'Penganti/LMT',
                                            'text' => '',
                                            'number' => 'LMT',
                                        ]
                                        
                        );
                        echo Html::a($lmt, ['keselamatan/laporan-kehadiran-lmt']);
                        ?>
                    </div>
                    <div class="col-xs-12 col-md-3">
                        <?php
                        $lmt = \yiister\gentelella\widgets\StatsTile::widget(
                                        
                                           [
                                            'icon' => 'clock-o',
                                            'header' => 'RollCall',
                                            'text' => '',
                                            'number' => 'Baris',
                                        ]
                                        
                        );
                        echo Html::a($lmt, ['keselamatan/laporan-kehadiran-lmt']);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>