<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
error_reporting(0); 

?>

<!--<div class="row">
<div class="col-md-12">
    <php echo $this->render('/pengesahan/_topmenu'); ?> 
</div>
</div>-->

<div class="row">  
        <div class="col-md-12 col-sm-12 col-xs-12" > 
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong><i class="fa fa-list"></i> Senarai Kakitangan Tetap [Pentadbiran]  </strong></h2>
<!--                    <p align="right"><= \yii\helpers\Html::a('Kembali', ['halaman-pengesahan-pentadbiran'], ['class' => 'btn btn-primary']) ?></p>   -->
                <div class="clearfix"></div>
                </div>
                
            <div class="well well-lg">  
            <div class="row">
                
                <div class="col-xs-12 col-md-6">
                    <?php
                    $belum_mohon = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        'header' => 'Senarai Kakitangan Tetap yang Cukup Tempoh [Pentadbiran]',
                                        'text' => 'Senarai Kakitangan Tetap yang Cukup Tempoh [Pentadbiran]',
                                        'number' => '1',
                                    ]
                    );
                    echo Html::a($belum_mohon, ['belummohon'], ['target' => '_blank']);
                    ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <?php
                    $belum_mohon = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        'header' => 'Senarai Kakitangan Tetap yang Akan Cukup Tempoh [Pentadbiran]',
                                        'text' => 'Senarai Kakitangan Tetap yang Akan Cukup Tempoh [Pentadbiran]',
                                        'number' => '2',
                                    ]
                    );
                    echo Html::a($belum_mohon, ['belummohon2'], ['target' => '_blank']);
                    ?>
                </div> 
                <!-- <div class="col-xs-12 col-md-6">
                    <php
                    $belum_mohon = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        'header' => 'Senarai Kakitangan Tetap yang Cukup Tempoh 6 Bulan [Pentadbiran]',
                                        'text' => 'Senarai Kakitangan Tetap yang Cukup Tempoh 6 Bulan Dalam Percubaan Lantikan Semula [Pentadbiran]',
                                        'number' => '3',
                                    ]
                    );
                    echo Html::a($belum_mohon, ['belummohon3'], ['target' => '_blank']);
                    ?>
                </div>  -->
<!--                <div class="col-xs-12 col-md-6">
                    <php
                    $belum_mohon = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        'header' => 'Senarai Kakitangan Tetap Dalam Percubaan Lanjutan [Pentadbiran]',
                                        'text' => 'Senarai Kakitangan Tetap Dalam Percubaan Lanjutan Tanpa Denda/Dalam Percubaan Lanjutan Berdenda [Pentadbiran]',
                                        'number' => '3',
                                    ]
                    );
                    echo Html::a($belum_mohon, ['belummohon4'], ['target' => '_blank']);
                    ?>
                </div>-->
                <div class="col-xs-12 col-md-6">
                    <?php
                    $belum_mohon = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        'header' => 'Senarai Kakitangan Tetap yang Cukup Tempoh Tapi Melebihi 3 Tahun [Pentadbiran]',
                                        'text' => 'Senarai Kakitangan Tetap yang Cukup Tempoh Tapi Melebihi 3 Tahun [Pentadbiran]',
                                        'number' => '3',
                                    ]
                    );
                    echo Html::a($belum_mohon, ['belummohon5'], ['target' => '_blank']);
                    ?>
                </div> 
            </div>
            </div>
                
            </div>
        </div>
</div>
