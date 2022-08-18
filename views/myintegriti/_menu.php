<?php 
use yii\helpers\Html;
?>
<style>
    .row i{
        color:green;
    }
    body .container.body .right_col{
        background: url(../images/myi.png) fixed;
        background-size: cover;color: black;
    }
    
    .btn-success{
        background-color: green;color:white;
    }
</style>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-10 center-margin">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['myintegriti/index']) ?></li>
        <li><?= $model->buttonA ?></li>
        <li><?= $model->buttonB ?></li>
        <li><?= $model->buttonC ?></li>
    </ol></div>
</div>