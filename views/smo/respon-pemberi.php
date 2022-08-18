<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use dosamigos\tinymce\TinyMce;
use kartik\select2\Select2;
?>

<?= Yii::$app->controller->renderPartial('/smo/_menu'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-info-circle">&nbsp;<strong>Butiran Maklumbalas</strong></i></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?= Yii::$app->controller->renderPartial('/smo/view-k1', ['model' => $model]); ?>
            </div>
        </div>
    </div>
</div>

<?= Yii::$app->controller->renderPartial('/smo/respon-view', [
    'responList' => $responList,
    'respon' => $respon,
    'model' => $model,
    'icno' => $icno,
    'redirectUrl' => $redirectUrl,
    'bil' => $bil,
]); ?>