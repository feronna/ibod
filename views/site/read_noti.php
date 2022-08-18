<?php

use yii\helpers\Html;
?>

<div class="col-md-12">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['site/index']) ?></li>
        <li><?= Html::a('Pusat Notifikasi', ['site/notifikasi']) ?></li>
        <li><?=$ntf->title ?></li>
    </ol>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-inbox"></i> Notifikasi [ <?=$ntf->title ?> ]</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <strong>Tarikh / Masa : <?=$ntf->formattedntfdt ?></strong>
                <br>
                <br>
                <p><?=$ntf->content ?></p>
            </div>
            
        </div>
    </div>
</div>
<?= Html::a('<i class="fa fa-arrow-left"></i> Kembali', ['site/notifikasi'], ['class'=>'btn btn-primary']) ?>