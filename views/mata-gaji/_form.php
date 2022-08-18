<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\tblrscopersalpoint */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblrscopersalpoint-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ICNO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PerSalPointStDt')->textInput() ?>

    <?= $form->field($model, 'PerSalPointEndDt')->textInput() ?>

    <?= $form->field($model, 'SalPointCd')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
