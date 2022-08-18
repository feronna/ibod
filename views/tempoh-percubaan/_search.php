<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\tblrscoprobtnperiodSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblrscoprobtnperiod-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ICNO') ?>

    <?= $form->field($model, 'ProbtnPeriod') ?>

    <?= $form->field($model, 'ProbtnStDt') ?>

    <?= $form->field($model, 'ProbtnEndDt') ?>

    <?= $form->field($model, 'ProbtnPeriodMin') ?>

    <?php // echo $form->field($model, 'id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
