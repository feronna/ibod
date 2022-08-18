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
                    <h2><strong><i class="fa fa-list"></i> Senarai Kakitangan Tetap [Akademik (DU51P) ]  </strong></h2>
<!--                    <p align="right"><= \yii\helpers\Html::a('Kembali', ['halaman-pengesahan-akademik'], ['class' => 'btn btn-primary']) ?></p>   -->
                <div class="clearfix"></div>
                </div>
                
            <div class="well well-lg">  
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <?php
                    $belum_mohon_du = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        'header' => 'Senarai Kakitangan Tetap yang Cukup Tempoh [Akademik (DU51P)]',
                                        'text' => 'Senarai Kakitangan Tetap yang Cukup Tempoh [Akademik  (DU51P)]',
                                        'number' => '1',
                                    ]
                    );
                    echo Html::a($belum_mohon_du, ['belummohondu'], ['target' => '_blank']);
                    ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <?php
                    $belum_mohon_du = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        'header' => 'Senarai Kakitangan Tetap yang Akan Cukup Tempoh [Akademik  (DU51P)]',
                                        'text' => 'Senarai Kakitangan Tetap yang Akan Cukup Tempoh [Akademik  (DU51P)]',
                                        'number' => '2',
                                    ]
                    );
                    echo Html::a($belum_mohon_du, ['belummohondu2'], ['target' => '_blank']);
                    ?>
                </div> 
                <div class="col-xs-12 col-md-6">
                    <?php
                    $belum_mohon_du = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        'header' => 'Senarai Kakitangan Tetap yang Cukup Tempoh Tapi Melebihi 3 Tahun [Akademik (DU51P)]',
                                        'text' => 'Senarai Kakitangan Tetap yang Cukup Tempoh Tapi Melebihi 3 Tahun [Akademik (DU51P)]',
                                        'number' => '3',
                                    ]
                    );
                    echo Html::a($belum_mohon_du, ['belummohondu5'], ['target' => '_blank']);
                    ?>
                </div>
            </div>
            </div>
                
            </div>
        </div>
</div>
