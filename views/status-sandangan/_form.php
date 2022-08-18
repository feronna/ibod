<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblrscosandangan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblrscosandangan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ICNO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gredjawatan')->textInput() ?>

    <?= $form->field($model, 'sandangan_id')->textInput() ?>

    <?= $form->field($model, 'ApmtTypeCd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'start_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
