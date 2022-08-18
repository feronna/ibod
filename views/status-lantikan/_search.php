<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TblrscoapmtstatusSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblrscoapmtstatus-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ICNO') ?>

    <?= $form->field($model, 'ApmtStatusCd') ?>

    <?= $form->field($model, 'ApmtStatusStDt') ?>

    <?= $form->field($model, 'ApmtStatusEndDt') ?>

    <?= $form->field($model, 'id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
