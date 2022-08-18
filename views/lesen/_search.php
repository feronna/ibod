<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\TbllesenSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbllesen-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'licId') ?>

    <?= $form->field($model, 'ICNO') ?>

    <?= $form->field($model, 'LicNo') ?>

    <?= $form->field($model, 'LicCd') ?>

    <?= $form->field($model, 'LicClassCd') ?>

    <?php // echo $form->field($model, 'LicExpiryDt') ?>

    <?php // echo $form->field($model, 'LicRnwlFee') ?>

    <?php // echo $form->field($model, 'FirstLicIssuedDt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
