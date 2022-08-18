<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\tblrscosaltype */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblrscosaltype-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ICNO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SalTypeCd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SalStatus')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SalTypeStDt')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
