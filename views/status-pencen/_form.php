<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\tblrscopsnstatus */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblrscopsnstatus-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ICNO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PsnStatusCd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PsnStatusNo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PsnIncomeTaxNo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PsnEpfNo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PsnStatusStDt')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
