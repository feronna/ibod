<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<?= Yii::$app->controller->renderPartial('_menu'); ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><?= Html::a('Pengenalan', Url::to(['intro'])) ?></li>
        <li class="breadcrumb-item" aria-current="page"><?= Html::a('Bahagian A', Url::to(['bhgn-a'])) ?></li>
        <li class="breadcrumb-item" aria-current="page"><?= Html::a('Bahagian B', Url::to(['bhgn-b'])) ?></li>
        <li class="breadcrumb-item" aria-current="page"><?= Html::a('Bahagian C', Url::to(['bhgn-c'])) ?></li>
        <li class="breadcrumb-item" aria-current="page"><?= Html::a('Bahagian D', Url::to(['bhgn-d'])) ?></li>
        <li class="breadcrumb-item" aria-current="page"><?= Html::a('Bahagian E', Url::to(['bhgn-e'])) ?></li>
        <li class="breadcrumb-item active" aria-current="page">Komen</li>
    </ol>
</nav>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-home"></i>&nbsp;<strong><?= $this->title ?></strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <p>
                    Anda telah melengkapkan soal selidik ini. Terima kasih atas sumbangan anda dalam meningkatkan kecemerlangan tadbir urus universiti.
                </p>
                <p style="color: green">
                    <i>
                        You have completed this questionnaire. Thank you for your contribution in enhancing the excellence of the university’s governance.
                    </i>
                </p>

                <?php
                $form = ActiveForm::begin([
                    'enableAjaxValidation' => false,
                    'fieldConfig' => [
                        'options' => [
                            'tag' => false,
                        ],
                    ],
                    'options' => ['class' => 'form-horizontal form-label-left']
                ]);
                ?>
                <br>
                <div class="form-group">
                    <p>Apakah komen anda mengenai soal selidik ini?<br>
                        <i style="color: green">What is your comment in regard to this questionnaire?</i>
                    </p>
                    <?= $form->field($model, 'komen')->textarea(['rows' => '6'])->label(false) ?>
                </div>
                <br>
                <div class="form-group">
                    <p>Apakah cadangan/komen anda berkaitan kegembiraan anda di Universiti Malaysia Sabah?<br>
                        <i style="color: green">What is your suggestion/comment in regard to your happiness in Universiti Malaysia Sabah?</i>
                    </p>
                    <?= $form->field($model, 'cadangan')->textarea(['rows' => '6'])->label(false) ?>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="text-center">
                        <?= Html::a('<i class="fa fa-arrow-left"></i> Sebelumnya / Back', Url::to(['bhgn-e']), ['class' => 'btn btn-warning']) ?>
                        &nbsp;
                        <?= Html::submitButton('Papar Keputusan&nbsp;<i class="fa fa-arrow-right"></i>', ['class' => 'btn btn-success ']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>