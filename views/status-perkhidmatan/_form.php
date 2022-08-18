<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\tblrscoservstatus */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblrscoservstatus-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ICNO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ServStatusCd')->textInput() ?>

    <?= $form->field($model, 'ServStatusDtl')->textInput() ?>

    <?= $form->field($model, 'ServStatusStDt')->textInput() ?>

    <?= $form->field($model, 'sebab_berhenti')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
