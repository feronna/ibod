<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\cbelajar\LkkTblPenyelia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lkk-tbl-penyelia-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'icno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jawatan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jabatan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'access_level')->textInput() ?>

    <?= $form->field($model, 'last_login')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_ipaccess')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'staff_icno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'HighestEduLevelCd')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
