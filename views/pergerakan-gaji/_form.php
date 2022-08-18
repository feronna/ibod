<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\tblrscosalmovemth */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblrscosalmovemth-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ICNO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SalMoveMth')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SalMoveMthType')->textInput() ?>

    <?= $form->field($model, 'SalMoveMthStDt')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
