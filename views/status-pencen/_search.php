<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\tblrscopsnstatusSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblrscopsnstatus-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ICNO') ?>

    <?= $form->field($model, 'PsnStatusCd') ?>

    <?= $form->field($model, 'PsnStatusNo') ?>

    <?= $form->field($model, 'PsnIncomeTaxNo') ?>

    <?= $form->field($model, 'PsnEpfNo') ?>

    <?php // echo $form->field($model, 'PsnStatusStDt') ?>

    <?php // echo $form->field($model, 'id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
