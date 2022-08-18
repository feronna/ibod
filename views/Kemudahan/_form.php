<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tblbuka\Tbltuntutan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kemudahan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'icno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jeniskemudahan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kodAkaun')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'syarat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_penyelia')->textInput() ?>

    <?= $form->field($model, 'entry_created')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
