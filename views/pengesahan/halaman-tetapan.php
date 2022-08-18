<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
error_reporting(0); 
?>

<div class="row">    
        <div class="col-md-12 col-sm-12 col-xs-12" > 
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong><i class="fa fa-list"></i> Tetapan Pengesahan Dalam Perkhidmatan</strong></h2>
                    <p align="right"><?= \yii\helpers\Html::a('Kembali', ['halaman-utama-pengesahan'], ['class' => 'btn btn-primary']) ?></p>   
                <div class="clearfix"></div>
                </div>
                
            <div class="well well-lg">  
            <div class="row">
                
                <div class="col-xs-12 col-md-6">
                    <?php
                    $pengesahan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        'header' => 'Urus Mesyuarat',
                                        'text' => 'Urus Mesyuarat Pengesahan Dalam Perkhidmatan',
                                        'number' => '1',
                                    ]
                    );
//                    echo Html::a($rekod_lantikan, ['']);
                    echo Html::a($pengesahan, ['urus-mesyuarat'], ['target' => '_blank']);
                    ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <?php
                    $pengesahan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'calendar',
                                        'header' => 'Tetapan',
                                        'text' => 'Tetapan Modul Pengesahan Dalam Perkhidmatan',
                                        'number' => '2',
                                    ]
                    );
                    echo Html::a($pengesahan, ['tetapan'], ['target' => '_blank']);
                    ?>
                </div> 
                <div class="col-xs-12 col-md-6">
                    <?php
                    $pengesahan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        'header' => 'Laporan',
                                        'text' => 'Laporan Pengesahan Dalam Perkhidmatan',
                                        'number' => '3',
                                    ]
                    );
                    echo Html::a($pengesahan, ['laporan'], ['target' => '_blank']);
                    ?>
                </div>
            </div>
            </div>
                
            </div>
        </div>
</div>
