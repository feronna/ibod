<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\kehadiran\tblwp */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblwp-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'wp_id')->textInput() ?>

    <?= $form->field($model, 'icno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'entry_dt')->textInput() ?>

    <?= $form->field($model, 'ver_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ver_dt')->textInput() ?>

    <?= $form->field($model, 'ver_remark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'app_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'app_dt')->textInput() ?>

    <?= $form->field($model, 'app_remark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'start_date')->textInput() ?>

    <?= $form->field($model, 'end_date')->textInput() ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
