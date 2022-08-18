<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\tblrscoretireage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblrscoretireage-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ICNO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'RetireAgeCd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CORetireAgeEftvDt')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
