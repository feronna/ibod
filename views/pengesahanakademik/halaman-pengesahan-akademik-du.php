<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
error_reporting(0); 
?>

<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12" > 
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong><i class="fa fa-list"></i> Pengesahan Dalam Perkhidmatan [Akademik (DU51P)] </strong></h2>
                    <p align="right"><?= \yii\helpers\Html::a('Kembali', ['pengesahan/halaman-utama-pengesahan'], ['class' => 'btn btn-primary']) ?></p>   
                <div class="clearfix"></div>
                </div>
                
            <div class="well well-lg">  
            <div class="row">
                
                <div class="col-xs-12 col-md-6">
                    <?php
                    $pengesahan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        'header' => 'Senarai Permohonan',
                                        'text' => 'Senarai Permohonan [Akademik (DU51P)]',
                                        'number' => '1',
                                    ]
                    );
//                    echo Html::a($rekod_lantikan, ['']);
                    echo Html::a($pengesahan, ['pengesahanakademik/senarai-perubatan-pelatih'], ['target' => '_blank']);
                    ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <?php
                    $pengesahan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        'header' => 'Rekod Permohonan',
                                        'text' => 'Rekod Permohonan [Akademik (DU51P)]',
                                        'number' => '2',
                                    ]
                    );
                    echo Html::a($pengesahan, ['pengesahanakademik/rekod-perubatan-pelatih'], ['target' => '_blank']);
                    ?>
                </div> 
                <div class="col-xs-12 col-md-6">
                    <?php
                    $pengesahan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'users',
                                        'header' => 'Senarai Kakitangan',
                                        'text' => 'Senarai Kakitangan [Akademik (DU51P)]',
                                        'number' => '3',
                                    ]
                    );
                    echo Html::a($pengesahan, ['pengesahanakademik/halaman-belum-mohon-du'], ['target' => '_blank']);
                    ?>
                </div>
                  
                    
            </div>
            </div>
                
            </div>
        </div>
</div>
