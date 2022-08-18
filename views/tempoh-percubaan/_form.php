<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\tblrscoprobtnperiod */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblrscoprobtnperiod-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ICNO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ProbtnPeriod')->textInput() ?>

    <?= $form->field($model, 'ProbtnStDt')->textInput() ?>

    <?= $form->field($model, 'ProbtnEndDt')->textInput() ?>

    <?= $form->field($model, 'ProbtnPeriodMin')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
