<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblrscoadminpost */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblrscoadminpost-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ICNO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'adminpos_id')->textInput() ?>

    <?= $form->field($model, 'jobStatus')->textInput() ?>

    <?= $form->field($model, 'paymentStatus')->textInput() ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description_sef')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dept_id')->textInput() ?>

    <?= $form->field($model, 'campus_id')->textInput() ?>

    <?= $form->field($model, 'appoinment_date')->textInput() ?>

    <?= $form->field($model, 'start_date')->textInput() ?>

    <?= $form->field($model, 'end_date')->textInput() ?>

    <?= $form->field($model, 'flag')->textInput() ?>

    <?= $form->field($model, 'files')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'renew')->textInput() ?>

    <?= $form->field($model, 'status_tugas')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
