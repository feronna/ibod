<?php

use yii\helpers\Html;

$this->title = 'Soal Selidik Ditutup';
?>


<?= Yii::$app->controller->renderPartial('_menu'); ?>
<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-briefcase"></i>&nbsp;<strong><?= Html::encode($this->title) ?></strong></h2>
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <h1 style="color:red;" class="text-center">Pengisian Soal Selidik Darjah Kegembiraan UMS ditutup buat sementara waktu.</h1>
    </div>

</div>