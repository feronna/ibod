<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\tblrscoconfirmstatus */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblrscoconfirmstatus-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ICNO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ConfirmStatusCd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ConfirmStatusStDt')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
